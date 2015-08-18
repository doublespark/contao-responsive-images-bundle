<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Responsive_images
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'Contao\ContentResponsiveImage' => 'system/modules/responsive_images/elements/ContentResponsiveImage.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_responsive_image'  => 'system/modules/responsive_images/templates',
	'css_responsive_image' => 'system/modules/responsive_images/templates',
));
