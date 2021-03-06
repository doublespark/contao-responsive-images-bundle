<?php

namespace Doublespark\ResponsiveImages\Elements;

use Contao\Config;
use Contao\ContentElement;
use Contao\Environment;
use Contao\FilesModel;
use Contao\ContentModel;
use Contao\System;
use Contao\Validator;
use Doublespark\ResponsiveImages\Models\DsImageSizesModel;


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
		if($this->defaultSRC == '')
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
			else
			{
					return '';
			}
		}

		$this->objFile = FilesModel::findByUuid($this->defaultSRC);

		if ($this->objFile === null)
		{
			if (!Validator::isUuid($this->defaultSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

		if ($this->objFile === null || !is_file(TL_ROOT . '/' . $this->objFile->path))
		{
			return '';
		}

		$this->defaultSRC = $this->objFile->path;
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		// Default breakpoints
		$arrBreakPoints = array(
			'tablet' => 700,
			'desktop' => 980,
			'large' => 1400
		);

		// Override breakpoints if they have been set in the config
		foreach($arrBreakPoints as $k => $v)
		{
			if(isset($GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k]) AND $GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k] != '')
			{
				$arrBreakPoints[$k] = $GLOBALS['TL_CONFIG']['RESPONSIVE_IMAGES'][$k];
			}
		}

		// Use meta data from the file manager if it exists
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

		$this->addImageToTemplate($this->Template, $this->arrData);

		$this->Template->alt = $this->arrData['alt'];

        $arrMobile  = unserialize($this->imagesize_mobile);
        $arrTablet  = unserialize($this->imagesize_tablet);
        $arrDesktop = unserialize($this->imagesize_desktop);
        $arrLarge   = unserialize($this->imagesize_large);

        $useCssBackground = $this->img_use_css_background;
        $fullWidth        = $this->responsiveImageFullWidth;

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
                $fullWidth        = $objPreset->responsiveImageFullWidth;
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

		$this->Template->mobile_url  = $this->generateResponsiveURL($mobileSRC, $arrMobile[0], $arrMobile[1], $arrMobile[2]);
		$this->Template->tablet_url  = $this->generateResponsiveURL($tabletSRC, $arrTablet[0], $arrTablet[1], $arrTablet[2]);
		$this->Template->desktop_url = $this->generateResponsiveURL($desktopSRC, $arrDesktop[0], $arrDesktop[1], $arrDesktop[2]);
		$this->Template->large_url   = $this->generateResponsiveURL($largeSRC, $arrLarge[0], $arrLarge[1], $arrLarge[2]);

		if(TL_MODE == 'FE')
		{
			$this->Template->defaultSRC = 'bundles/doublesparkresponsiveimages/img/placeholder.jpg';
			$this->Template->src       = 'bundles/doublesparkresponsiveimages/img/placeholder.jpg';
		}

        if(($useCssBackground || $fullWidth) AND TL_MODE == 'FE')
        {
            $imageID = 'resImage_'.$this->id;

            $this->Template->useCSS = true;
            $this->Template->imgID  = $imageID;

            $objCSS              = new \FrontendTemplate('css_responsive_image');
            $objCSS->imgID       = $imageID;

            $objCSS->fullWidth     = $fullWidth;

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

			// Work around to stop output of HTML template tags in debug mode
			$debugMode = Config::get('debugMode');

            Config::set('debugMode',false);
            $css = $objCSS->parse();
            Config::set('debugMode',$debugMode);

            $cacheID = md5($imageID.$this->Template->mobile_url.$this->Template->tablet_url.$this->Template->desktop_url.$this->Template->large_url.$css);

            $cachePath = TL_ROOT.'/web/bundles/doublesparkresponsiveimages/cache/';

            if(!file_exists($cachePath.$cacheID.'.css'))
            {
                file_put_contents($cachePath.$cacheID.'.css',$css);
            }

            // Add OG tag for image
            $protocol = Environment::get('ssl') ? 'https://' : 'http://';
            $imgURL = $protocol.$_SERVER['HTTP_HOST'].'/'.$this->defaultSRC;
            $GLOBALS['TL_HEAD'][] = '<meta property="og:image" content="'.$imgURL.'"/>';


            $GLOBALS['TL_CSS'][] = 'bundles/doublesparkresponsiveimages/cache/'.$cacheID.'.css';
        }
	}

	/**
	 * Generates a responsive URL
	 */
	protected function generateResponsiveURL($src, $width, $height, $mode=NULL)
	{
        $container = System::getContainer();
        $rootDir   = $container->getParameter('kernel.project_dir');

        $image = $container
            ->get('contao.image.image_factory')
            ->create($rootDir.'/'.$src, [$width, $height, $mode])
            ->getUrl($rootDir);

        return $image;
	}

	/**
	 * Fetches a file path based on it's uuid, returns false if file doesn't exist
	 * @param  String $uuid
	 * @return Mixed
	 */
	protected function fetchFilePath($uuid)
	{
		$objFile = FilesModel::findByUuid($uuid);

		if($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
		{
			return FALSE;
		}

		return $objFile->path;
	}
}
