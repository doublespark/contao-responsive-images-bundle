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

$GLOBALS['TL_DCA']['tl_content']['palettes']['responsive_image'] = '{type_legend},type,headline;{source_legend},defaultSRC,mobileSRC,tabletSRC,desktopSRC,largeSRC;{image_legend},alt,title,imagemargin,imageUrl,fullsize,caption;{responsive_legend},img_size_preset,img_use_custom_sizes;{text_legend},image_text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'img_use_custom_sizes';

// Subpalettes
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['img_use_custom_sizes'] = 'imagesize_mobile,imagesize_tablet,imagesize_desktop,imagesize_large,img_use_css_background,responsiveImageFullWidth';

// Default
$GLOBALS['TL_DCA']['tl_content']['fields']['defaultSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['defaultSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

// Mobile -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['mobileSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['mobileSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_mobile'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagesize_mobile'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => System::getImageSizes(),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Tablet -------------------------- //

$GLOBALS['TL_DCA']['tl_content']['fields']['tabletSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['tabletSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_tablet'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagesize_tablet'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => System::getImageSizes(),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Desktop -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['desktopSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['desktopSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_desktop'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagesize_desktop'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => System::getImageSizes(),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Large -------------------------- //

$GLOBALS['TL_DCA']['tl_content']['fields']['largeSRC'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['largeSRC'],
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_large'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['imagesize_large'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => System::getImageSizes(),
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Text field

$GLOBALS['TL_DCA']['tl_content']['fields']['image_text'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['text'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_use_css_background'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['img_use_css_background'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['responsiveImageFullWidth'] = array(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['responsiveImageFullWidth'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_use_custom_sizes'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['img_use_custom_sizes'],
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_size_preset'] = array(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['img_size_preset'],
    'inputType'               => 'select',
    'foreignKey'              => 'tl_ds_image_sizes.title',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'includeBlankOption' => true),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);
