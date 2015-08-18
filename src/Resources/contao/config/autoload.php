<?php

/**
 * Contao Open Source CMS
 * @package Responsive_images
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Elements
	'Contao\ContentResponsiveImage' => 'vendor/doublespark/contao-responsive-images-bundle/src/Resources/contao/elements/ContentResponsiveImage.php'
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'ce_responsive_image'  => 'vendor/doublespark/contao-responsive-images-bundle/src/Resources/contao/templates',
	'css_responsive_image' => 'vendor/doublespark/contao-responsive-images-bundle/src/Resources/contao/templates',
));
