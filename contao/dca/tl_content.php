<?php

use Contao\System;

$GLOBALS['TL_DCA']['tl_content']['palettes']['responsive_image'] = '{type_legend},type,headline;{source_legend},defaultSRC,mobileSRC,tabletSRC,desktopSRC,largeSRC;{image_legend},alt,title,imagemargin,imageUrl,fullsize,caption,img_use_ogtag;{responsive_legend},img_size_preset,img_use_custom_sizes;{text_legend},image_text;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'img_use_custom_sizes';

// Subpalettes
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['img_use_custom_sizes'] = 'imagesize_mobile,imagesize_tablet,imagesize_desktop,imagesize_large,img_use_css_background,responsiveImageFullWidth';

// Default
$GLOBALS['TL_DCA']['tl_content']['fields']['defaultSRC'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

// Mobile -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['mobileSRC'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_mobile'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
    'options'                 => System::getContainer()->get('contao.image.sizes')->getAllOptions(),
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Tablet -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['tabletSRC'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_tablet'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
    'options'                 => System::getContainer()->get('contao.image.sizes')->getAllOptions(),
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Desktop -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['desktopSRC'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_desktop'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
    'options'                 => System::getContainer()->get('contao.image.sizes')->getAllOptions(),
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Large -------------------------- //
$GLOBALS['TL_DCA']['tl_content']['fields']['largeSRC'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['imagesize_large'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
    'options'                 => System::getContainer()->get('contao.image.sizes')->getAllOptions(),
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

// Text field

$GLOBALS['TL_DCA']['tl_content']['fields']['image_text'] = array(
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true, 'tl_class'=>'clr'),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_use_css_background'] = array(
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_use_ogtag'] = array(
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['responsiveImageFullWidth'] = array(
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_use_custom_sizes'] = array(
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['img_size_preset'] = array(
    'inputType'               => 'select',
    'foreignKey'              => 'tl_ds_image_sizes.title',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'includeBlankOption' => true),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);
