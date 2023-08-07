<?php

use Doublespark\ContaoResponsiveImagesBundle\Elements\ResponsiveImageElementController;

$GLOBALS['TL_DCA']['tl_content']['palettes'][ResponsiveImageElementController::TYPE] = '{type_legend},type;{source_legend},dsImg_defaultSrc,dsImg_mobileSrc,dsImg_tabletSrc,dsImg_desktopSrc,dsImg_largeSrc;{image_legend},alt,dsImg_openGraph;{responsive_legend},dsImg_sizePreset,dsImg_useCustomSizes;{text_legend},dsImg_imageText;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$GLOBALS['TL_DCA']['tl_content']['palettes']['__selector__'][] = 'dsImg_useCustomSizes';

// Subpalettes
$GLOBALS['TL_DCA']['tl_content']['subpalettes']['dsImg_useCustomSizes'] = 'dsImg_sizeMobile,dsImg_sizeTablet,dsImg_minWidthTablet,dsImg_sizeDesktop,dsImg_minWidthDesktop,dsImg_sizeLarge,dsImg_minWidthLarge';

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_defaultSrc'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'mandatory' => true, 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_mobileSrc'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_sizeMobile'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);


$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_tabletSrc'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_sizeTablet'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_minWidthTablet'] = array(
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_desktopSrc'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_minWidthDesktop'] = array(
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_sizeDesktop'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_largeSrc'] = array
(
	'exclude'                 => true,
	'inputType'               => 'fileTree',
	'eval'                    => array('filesOnly'=>true, 'fieldType'=>'radio', 'tl_class'=>'clr'),
	'sql'                     => "binary(16) NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_minWidthLarge'] = array(
    'exclude'                 => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_sizeLarge'] = array(
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_imageText'] = array(
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'textarea',
	'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'tl_class'=>'clr'),
	'sql'                     => "mediumtext NULL"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_openGraph'] = array(
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_useCustomSizes'] = array(
    'inputType'               => 'checkbox',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_content']['fields']['dsImg_sizePreset'] = array(
    'inputType'               => 'select',
    'foreignKey'              => 'tl_ds_image_sizes.title',
    'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr', 'includeBlankOption' => true),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
);
