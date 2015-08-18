<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Core
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class ContentResponsiveImage
 *
 * Front end content element "responsive image".
 * @copyright  Doublespark 2013
 * @author     Jamie Devine
 * @package    Core
 */
class ContentResponsiveImage extends \ContentElement
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_responsive_image';


	/**
	 * Return if the image does not exist
	 * @return string
	 */
	public function generate()
	{
		if($this->singleSRC == '')
		{
			return '';
		}

		$objFile = \FilesModel::findByUuid($this->singleSRC);

		if ($objFile === null)
		{
			if (!\Validator::isUuid($this->singleSRC))
			{
				return '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
			}

			return '';
		}

		if ($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
		{
			return '';
		}

		$this->singleSRC = $objFile->path;
		return parent::generate();
	}


	/**
	 * Generate the content element
	 */
	protected function compile()
	{
		$this->addImageToTemplate($this->Template, $this->arrData);

		$arrMobile  = unserialize($this->imagesize_mobile);
		$arrTablet  = unserialize($this->imagesize_tablet);
		$arrDesktop = unserialize($this->imagesize_desktop);
		$arrLarge   = unserialize($this->imagesize_large);

		// Default to the singleSRC image
		$mobileSRC  = $this->singleSRC;
		$desktopSRC = $this->singleSRC;
		$tabletSRC  = $this->singleSRC;
		$largeSRC   = $this->singleSRC;

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
			$this->Template->singleSRC = 'bundles/doublesparkresponsiveimages/img/placeholder.jpg';
			$this->Template->src       = 'bundles/doublesparkresponsiveimages/img/placeholder.jpg';
		}

        if(($this->img_use_css_background || $this->responsiveImageFullWidth) AND TL_MODE == 'FE')
        {
            $imageID = 'resImage_'.$this->id;

            $this->Template->useCSS = true;
            $this->Template->imgID  = $imageID;

            $objCSS              = new \FrontendTemplate('css_responsive_image');
            $objCSS->imgID       = $imageID;

			$objCSS->fullWidth     = $this->responsiveImageFullWidth;

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

			// Work around to stop output of HTML template tags in debug mode
			$debugMode = \Config::get('debugMode');

			\Config::set('debugMode',false);
            $css = $objCSS->parse();
			\Config::set('debugMode',$debugMode);

            $cacheID = md5($imageID.$this->Template->mobile_url.$this->Template->tablet_url.$this->Template->desktop_url.$this->Template->large_url.$css);

            $cachePath = TL_ROOT.'/web/bundles/doublesparkresponsiveimages/cache/';

            if(!file_exists($cachePath.$cacheID.'.css'))
            {
                file_put_contents($cachePath.$cacheID.'.css',$css);
            }

            $GLOBALS['TL_CSS'][] = 'bundles/doublesparkresponsiveimages/cache/'.$cacheID.'.css||static';
        }

	}

	/**
	 * Generates a responsive URL
	 * @param  [type] $src    [description]
	 * @param  [type] $width  [description]
	 * @param  [type] $height [description]
	 * @param  [type] $mode   [description]
	 * @return [type]         [description]
	 */
	protected function generateResponsiveURL($src, $width, $height, $mode=NULL)
	{
		return \Image::get($src, $width, $height, $mode);
	}

	/**
	 * Fetches a file path based on it's uuid, returns false if file doesn't exist
	 * @param  String $uuid
	 * @return Mixed
	 */
	protected function fetchFilePath($uuid)
	{
		$objFile = \FilesModel::findByUuid($uuid);

		if($objFile === null || !is_file(TL_ROOT . '/' . $objFile->path))
		{
			return FALSE;
		}

		return $objFile->path;
	}
}