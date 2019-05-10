<?php

/**
 * Contao Open Source CMS
 *
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

/**
 * Table tl_ds_image_sizes
 */
$GLOBALS['TL_DCA']['tl_ds_image_sizes'] = array
(

    // Config
    'config' => array
    (
        'dataContainer' => 'Table',
        'sql' => array
        (
            'keys' => array
            (
                'id'    => 'primary'
            )
        )
    ),

    // List
    'list' => array
    (
        'label' => array
        (
            'fields'                  => array('title'),
            'format'                  => '%s'
        ),
        'sorting' => array
        (
            'mode'                    => 1,
            'flag'                    => 1,
            'fields'                  => array('title'),
            'panelLayout'             => 'sort,search,limit;filter'
        ),
        'global_operations' => array
        (
            'all' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['copy'],
                'href'                => 'act=copy',
                'icon'                => 'copy.gif'
            ),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['cut'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.gif'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'   => 'title,imagesize_mobile,imagesize_tablet,imagesize_desktop,imagesize_large,img_use_css_background,responsiveImageFullWidth'
    ),

    // Fields
    'fields' => array
    (
        'id' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL auto_increment"
        ),
        'tstamp' => array
        (
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'title' => array (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'mandatory' => true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'imagesize_mobile' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['imagesize_mobile'],
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'options'                 => System::getImageSizes(),
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'imagesize_tablet' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['imagesize_tablet'],
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'options'                 => System::getImageSizes(),
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'imagesize_desktop' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['imagesize_desktop'],
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'options'                 => System::getImageSizes(),
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'imagesize_large' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['imagesize_large'],
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'options'                 => System::getImageSizes(),
            'reference'               => &$GLOBALS['TL_LANG']['MSC'],
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'img_use_css_background' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['img_use_css_background'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        ),
        'responsiveImageFullWidth' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_ds_image_sizes']['responsiveImageFullWidth'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'checkbox',
            'eval'                    => array('mandatory'=>false, 'tl_class'=>'clr'),
            'sql'                     => "char(1) NOT NULL default ''"
        )
    )
);