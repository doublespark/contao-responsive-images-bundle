<?php

namespace Doublespark\ContaoResponsiveImagesBundle\Elements;

use Contao\Config;
use Contao\ContentElement;
use Contao\Environment;
use Contao\FilesModel;
use Contao\ContentModel;
use Contao\FrontendTemplate;
use Contao\System;
use Contao\Validator;
use Doublespark\ContaoResponsiveImagesBundle\Models\DsImageSizesModel;
use Symfony\Component\Filesystem\Filesystem;


/**
 * Class ContentResponsiveImage
 *
 * Front end content element "responsive image".
 * @copyright  Doublespark 2013
 * @author     Jamie Devine
 * @package    Core
 */
class ContentResponsiveImage extends ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_responsive_image';

    /**
     * @var FilesModel
     */
	protected $objFile;

	/**
	 * Return if the image does not exist
	 * @return string
	 */
	public function generate()
	{
        $this->backwardsCompatability();

		$this->objFile = FilesModel::findByUuid($this->defaultSRC);

		if($this->objFile === null)
		{
			if (!Validator::isUuid($this->defaultSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

        $rootDir = System::getContainer()->getParameter('kernel.project_dir');

		if(!is_file($rootDir.'/'.$this->objFile->path))
		{
			return '';
		}

		$this->defaultSRC = $this->objFile->path;

        if(System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest(System::getContainer()->get('request_stack')->getCurrentRequest()))
        {
            return '<img src="'.$this->defaultSRC.'">';
        }

		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		// Default breakpoints
		$arrBreakPoints = [
			'tablet'  => 700,
			'desktop' => 980,
			'large'   => 1400
		];

		// Override breakpoints if they have been set in the config
		foreach($arrBreakPoints as $k => $v)
		{
			if(isset($GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k]) AND $GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k] != '')
			{
				$arrBreakPoints[$k] = $GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k];
			}
		}

		// Use metadata from the file manager if it exists
		if($this->objFile->meta)
        {
            $arrMeta = unserialize($this->objFile->meta);

            if(isset($arrMeta['en']))
            {
                foreach($arrMeta['en'] as $field => $value)
                {
                    if(empty($value))
                    {
                        continue;
                    }

                    if(isset($this->arrData[$field]))
                    {
                        $this->arrData[$field] = $value;
                    }
                }
            }
        }

		$this->Template->alt = $this->arrData['alt'];

        $arrMobile  = unserialize($this->imagesize_mobile);
        $arrTablet  = unserialize($this->imagesize_tablet);
        $arrDesktop = unserialize($this->imagesize_desktop);
        $arrLarge   = unserialize($this->imagesize_large);

        $useCssBackground = $this->img_use_css_background;

		if(!$this->img_use_custom_sizes && !empty($this->img_size_preset))
        {
            $objPreset = DsImageSizesModel::findByPk($this->img_size_preset);

            if($objPreset)
            {
                $arrMobile  = unserialize($objPreset->imagesize_mobile);
                $arrTablet  = unserialize($objPreset->imagesize_tablet);
                $arrDesktop = unserialize($objPreset->imagesize_desktop);
                $arrLarge   = unserialize($objPreset->imagesize_large);

                $useCssBackground = $objPreset->img_use_css_background;
            }
        }

		// Default to the defaultSRC image
		$mobileSRC  = $this->defaultSRC;
		$desktopSRC = $this->defaultSRC;
		$tabletSRC  = $this->defaultSRC;
		$largeSRC   = $this->defaultSRC;

		// Get mobile SRC override if one is set
		if($this->mobileSRC != '')
		{
			if($src = $this->fetchFilePath($this->mobileSRC))
			{
				$mobileSRC = $src;
			}
		}

		// Get tablet SRC override if one is set
		if($this->tabletSRC != '')
		{
			if($src = $this->fetchFilePath($this->tabletSRC))
			{
				$tabletSRC = $src;
			}
		}

		// Get desktop SRC override if one is set
		if($this->desktopSRC != '')
		{
			if($src = $this->fetchFilePath($this->desktopSRC))
			{
				$desktopSRC = $src;
			}
		}

		// Get large SRC override if one is set
		if($this->largeSRC != '')
		{
			if($src = $this->fetchFilePath($this->largeSRC))
			{
				$largeSRC = $src;
			}
		}

		$this->Template->mobile_url  = $this->getImage($mobileSRC, $arrMobile[0], $arrMobile[1], $arrMobile[2]);
		$this->Template->tablet_url  = $this->getImage($tabletSRC, $arrTablet[0], $arrTablet[1], $arrTablet[2]);
		$this->Template->desktop_url = $this->getImage($desktopSRC, $arrDesktop[0], $arrDesktop[1], $arrDesktop[2]);
		$this->Template->large_url   = $this->getImage($largeSRC, $arrLarge[0], $arrLarge[1], $arrLarge[2]);

        $isFrontend = System::getContainer()->get('contao.routing.scope_matcher')->isFrontendRequest(System::getContainer()->get('request_stack')->getCurrentRequest());

        if($isFrontend)
		{
			$this->Template->defaultSRC = 'bundles/doublesparkcontaoresponsiveimages/img/placeholder.jpg';
			$this->Template->src        = 'bundles/doublesparkcontaoresponsiveimages/img/placeholder.jpg';

            // Add OG tag for image
            if($this->img_use_ogtag && (!isset($GLOBALS['TL_HEAD']['ogImage']) || empty($GLOBALS['TL_HEAD']['ogImage'])))
            {
                $protocol = Environment::get('ssl') ? 'https://' : 'http://';
                $imgURL = $protocol.$_SERVER['HTTP_HOST'].'/'.$this->defaultSRC;

                $GLOBALS['TL_HEAD']['ogImage'] = '<meta property="og:image" content="'.$imgURL.'"/>';
            }
		}

        if(!$useCssBackground)
        {
            // Add JS breakpoints to head - used by the JS script
            $GLOBALS['TL_HEAD']['responsiveImageBreakpoints'] = '<script type="text/javascript">window.responsiveBreakPoints={"tablet":'.$arrBreakPoints['tablet'].',"desktop":'.$arrBreakPoints['desktop'].',"large":'.$arrBreakPoints['large']."};</script>";

            // Load JS
            $GLOBALS['TL_BODY']['responsiveImageJs'] = '<script type="text/javascript" src="/bundles/doublesparkcontaoresponsiveimages/js/responsive-images.min.js"></script>';
        }

        if($useCssBackground && $isFrontend)
        {
            $imageID = 'resImage_'.$this->id;

            $cacheID = md5($imageID.$this->Template->mobile_url.$this->Template->tablet_url.$this->Template->desktop_url.$this->Template->large_url);

            $rootDir = System::getContainer()->getParameter('kernel.project_dir');

            if((new Filesystem())->exists($rootDir.'/web'))
            {
                $webDir = 'web'; // backwards compatibility
            }
            else
            {
                $webDir = 'public';
            }

            $cachePath = $rootDir.'/'.$webDir.'/bundles/doublesparkcontaoresponsiveimages/cache/';

            $this->Template->useCSS = true;
            $this->Template->imgID  = $imageID;

            if(!file_exists($cachePath.$cacheID.'.css'))
            {
                $objCSS              = new FrontendTemplate('css_responsive_image');
                $objCSS->imgID       = $imageID;

                $objCSS->mobile_url    = $this->Template->mobile_url;
                $objCSS->mobile_width  = $arrMobile[0];
                $objCSS->mobile_height = $arrMobile[1];

                $objCSS->tablet_url    = $this->Template->tablet_url;
                $objCSS->tablet_width  = $arrTablet[0];
                $objCSS->tablet_height = $arrTablet[1];

                $objCSS->desktop_url    = $this->Template->desktop_url;
                $objCSS->desktop_width  = $arrDesktop[0];
                $objCSS->desktop_height = $arrDesktop[1];

                $objCSS->large_url    = $this->Template->large_url;
                $objCSS->large_width  = $arrLarge[0];
                $objCSS->large_height = $arrLarge[1];

                $objCSS->tabletBreakpoint  = $arrBreakPoints['tablet'];
                $objCSS->desktopBreakpoint = $arrBreakPoints['desktop'];
                $objCSS->largeBreakpoint   = $arrBreakPoints['large'];

                // Work around to stop output of HTML template comments
                $objCSS->setDebug(false);

                $css = $objCSS->parse();

                file_put_contents($cachePath.$cacheID.'.css',$css);
            }

            $GLOBALS['TL_CSS'][] = 'bundles/doublesparkcontaoresponsiveimages/cache/'.$cacheID.'.css';
        }
	}

    /**
     * Gets an image path
     * @param string $src
     * @param int $width
     * @param int $height
     * @param string|null $mode
     * @return string
     */
	protected function getImage(string $src, int $width, int $height, ?string $mode=null): string
	{
        $container = System::getContainer();
        $rootDir   = $container->getParameter('kernel.project_dir');

        $image = $container
            ->get('contao.image.factory')
            ->create($rootDir.'/'.$src, [$width, $height, $mode])
            ->getUrl($rootDir);

        return $image;
	}

    /**
     * Convert UUID into an image path
     * @param string $uuid
     * @return string
     */
	protected function fetchFilePath(string $uuid): string
	{
		$objFile = FilesModel::findByUuid($uuid);

        $rootDir = System::getContainer()->getParameter('kernel.project_dir');

		if($objFile === null || !is_file($rootDir . '/' . $objFile->path))
		{
			return '';
		}

		return $objFile->path;
	}

    /**
     * Copy value of singleSRC to defaultSRC if needed
     * @return void
     */
    protected function backwardsCompatability(): void
    {
        if($this->defaultSRC === '')
        {
            if(!empty($this->singleSRC))
            {
                $this->defaultSRC = $this->singleSRC;

                // For backwards compatibility, copy singleSRC to defaultSRC
                $objContent = ContentModel::findByPk($this->id);
                $objContent->defaultSRC = $objContent->singleSRC;
                $objContent->singleSRC  = '';
                $objContent->save();
            }
        }
    }
}
