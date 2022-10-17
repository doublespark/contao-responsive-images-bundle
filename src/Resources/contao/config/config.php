<?php

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ds_image_sizes'] = 'Doublespark\ContaoResponsiveImagesBundle\Models\DsImageSizesModel';

/**
 * Load JS
 */
if(TL_MODE == 'FE')
{
	$GLOBALS['TL_JAVASCRIPT']['responsive_images'] = 'web/bundles/doublesparkcontaoresponsiveimagesbundle/js/responsive-images.min.js|static';

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

	// Add JS breakpoints to head - used by the JS script
	$GLOBALS['TL_HEAD']['responsiveImageBreakpoints'] = '<script type="text/javascript">window.responsiveBreakPoints={"tablet":'.$arrBreakPoints['tablet'].',"desktop":'.$arrBreakPoints['desktop'].',"large":'.$arrBreakPoints['large']."};</script>";
}

// Add responsive image element
$GLOBALS['TL_CTE']['media']['responsive_image'] = 'Doublespark\ContaoResponsiveImagesBundle\Elements\ContentResponsiveImage';

/**
 * BACK END MODULES
 */
$GLOBALS['BE_MOD']['system']['tl_ds_image_sizes'] = [
    'tables' => ['tl_ds_image_sizes']
];