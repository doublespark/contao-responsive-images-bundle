<?php

declare(strict_types=1);

namespace Doublespark\ContaoResponsiveImagesBundle\Elements;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Image\Studio\Studio;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\Environment;
use Contao\FilesModel;
use Doublespark\ContaoResponsiveImagesBundle\Models\DsImageSizesModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(ResponsiveImageElementController::TYPE, category:'media', template: 'content_element/ds_responsive_image')]
class ResponsiveImageElementController extends AbstractContentElementController
{
    public const TYPE = 'ds_responsive_image';

    public function __construct(private Studio $studio)
    {
    }

    /**
     * @param FragmentTemplate $template
     * @param ContentModel $model
     * @param Request $request
     * @return Response
     */
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        // Get sizes
        $sizeMobile = '';
        $sizeTablet = '';
        $sizeDesktop = '';
        $sizeLarge = '';

        $minWidthTablet = 0;
        $minWidthDesktop = 0;
        $minWidthLarge  = 0;

        if($model->dsImg_useCustomSizes)
        {
            $sizeMobile  = $model->dsImg_sizeMobile;
            $sizeTablet  = $model->dsImg_sizeTablet;
            $sizeDesktop = $model->dsImg_sizeDesktop;
            $sizeLarge   = $model->dsImg_sizeLarge;

            $minWidthTablet  = $model->dsImg_minWidthTablet;
            $minWidthDesktop = $model->dsImg_minWidthDesktop;
            $minWidthLarge   = $model->dsImg_minWidthLarge;
        }
        else
        {
            $objPreset = DsImageSizesModel::findByPk($model->dsImg_sizePreset);

            if($objPreset)
            {
                $sizeMobile  = $objPreset->sizeMobile;
                $sizeTablet  = $objPreset->sizeTablet;
                $sizeDesktop = $objPreset->sizeDesktop;
                $sizeLarge   = $objPreset->sizeLarge;

                $minWidthTablet  = $objPreset->minWidthTablet;
                $minWidthDesktop = $objPreset->minWidthDesktop;
                $minWidthLarge   = $objPreset->minWidthLarge;
            }
        }

        /**
         * Get images, fallback to defaultSrc if no size-specific src is provided
         */
        $arrImages = [
            'default' => [
                'image' => $this->getImage($model->dsImg_mobileSrc ?? $model->dsImg_defaultSrc, $sizeMobile)
            ],
            'sources' => [
                'tablet' => [
                    'image'    => $this->getImage($model->dsImg_tabletSrc ?? $model->dsImg_defaultSrc, $sizeTablet),
                    'minWidth' => $minWidthTablet
                ],
                'desktop' => [
                    'image'    => $this->getImage($model->dsImg_desktopSrc ?? $model->dsImg_defaultSrc, $sizeDesktop),
                    'minWidth' => $minWidthDesktop
                ],
                'large' => [
                    'image'    =>  $this->getImage($model->dsImg_largeSrc ?? $model->dsImg_defaultSrc, $sizeLarge),
                    'minWidth' => $minWidthLarge
                ]
            ]
        ];

        if($this->isBackendScope())
        {
            $img = $arrImages['sources']['desktop']['image']['src'] ?? '';
            return new Response('<img src="'.$img.'" />');
        }

        // CSS which applies to all elements, only include in page once
        $GLOBALS['TL_HEAD']['ds_responsive_img'] = "<style>.content-ds_responsive_image .img {display:block;overflow:hidden;background-repeat:no-repeat;background-position:center center;width:100%;background-size:cover;}</style>";

        // CSS specific to this image
        $GLOBALS['TL_HEAD'][] = $this->getCss($model->id,$arrImages);

        // Add opengraph image tag
        if($model->dsImg_openGraph && (!isset($GLOBALS['TL_HEAD']['ogImage']) || empty($GLOBALS['TL_HEAD']['ogImage'])))
        {
            if(isset($arrImages['sources']['desktop']['image']['src']))
            {
                $imgURL = Environment::get('url').$arrImages['sources']['desktop']['image']['src'];
                $GLOBALS['TL_HEAD']['ogImage'] = '<meta property="og:image" content="'.$imgURL.'"/>';
            }
        }

        $template->set('id', 'resImage_'.$model->id);
        $template->set('text', $model->dsImg_imageText);
        $template->set('altText', $model->alt);

        return $template->getResponse();
    }

    protected function getCss(string|int $id, array $arrImages): string
    {
        $mobileSrc  = $arrImages['default']['image']['src'] ?? '';
        $mobileHeight  = $arrImages['default']['image']['height'] ?? '0';

        $mediaQueries = [];

        foreach($arrImages['sources'] as $source)
        {
            $src      = $source['image']['src'] ?? '';
            $minWidth = $source['minWidth'] ?? 0;
            $height   = $source['image']['height'] ?? 0;

            // Skip breakpoint if 0
            if((int)$minWidth === 0)
            {
                continue;
            }

            $mediaQueries[$minWidth] = "@media(min-width:{$minWidth}px){#resImage_$id{background-image:url('$src');height:{$height}px;}}";
        }

        $mediaQueries = count($mediaQueries) > 0 ? implode('',$mediaQueries) : '';

        return "<style>#resImage_$id{background-image:url('$mobileSrc');height:{$mobileHeight}px;}$mediaQueries</style>";
    }

    protected function getImage(string $uuid, string $size): array
    {
        $objFile = $this->getFileModel($uuid);

        if($objFile instanceof FilesModel)
        {
            $image = $this->studio
                ->createFigureBuilder()
                ->fromFilesModel($objFile)
                ->setSize($size)
                ->buildIfResourceExists();

            if(!$image)
            {
                return [];
            }

            return $image->getImage()->getImg();
        }

        return [];
    }

    protected function getFileModel(string $uuid): FilesModel|null
    {
        if(!empty($uuid))
        {
            $objFile = FilesModel::findByUuid($uuid);

            if($objFile)
            {
                return $objFile;
            }
        }

        return null;
    }
}