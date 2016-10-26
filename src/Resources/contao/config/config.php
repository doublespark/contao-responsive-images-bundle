<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Doublespark 2013
 * @author     Jamie Devine <jamie.devine@doublespark.co.uk>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */

define('RESPONSIVE_IMAGES_VERSION', '1.1.11');

/**
 * Load JS
 */
if(TL_MODE == 'FE')
{
	$GLOBALS['TL_JAVASCRIPT']['responsive_images'] = 'web/bundles/doublesparkresponsiveimages/js/responsive-images.js|static';

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
$GLOBALS['TL_CTE']['media']['responsive_image'] = 'ContentResponsiveImage';