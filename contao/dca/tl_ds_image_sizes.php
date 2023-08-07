<?php

use Contao\DC_Table;

/**
 * Table tl_ds_image_sizes
 */
$GLOBALS['TL_DCA']['tl_ds_image_sizes'] = array
(
    // Config
    'config' => array
    (
        'dataContainer' => DC_Table::class,
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
                'href'                => 'act=select',
                'class'               => 'header_edit_all',
                'attributes'          => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            )
        ),
        'operations' => array
        (
            'edit' => array
            (
                'href'                => 'act=edit',
                'icon'                => 'edit.svg'
            ),
            'copy' => array
            (
                'href'                => 'act=copy',
                'icon'                => 'copy.svg'
            ),
            'cut' => array
            (
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.svg'
            ),
            'delete' => array
            (
                'href'                => 'act=delete',
                'icon'                => 'delete.svg',
                'attributes'          => 'onclick="if(!confirm(\'' . ($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null) . '\'))return false;Backend.getScrollOffset()"'
            ),
            'show'
        )
    ),

    // Palettes
    'palettes' => array
    (
        'default'   => '{title_legend},title;{mobile_legend},sizeMobile;{tablet_legend},sizeTablet,minWidthTablet;{desktop_legend},sizeDesktop,minWidthDesktop;{large_legend},sizeLarge,minWidthLarge;'
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
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'mandatory' => true),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'sizeMobile' => array
        (
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'sizeTablet' => array
        (
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'minWidthTablet' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'sizeDesktop' => array
        (
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'minWidthDesktop' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
        'sizeLarge' => array
        (
            'exclude'                 => true,
            'inputType'               => 'imageSize',
            'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "varchar(64) NOT NULL default ''"
        ),
        'minWidthLarge' => array
        (
            'exclude'                 => true,
            'inputType'               => 'text',
            'eval'                    => array('rgxp'=>'natural', 'nospace'=>true, 'mandatory' => true, 'tl_class'=>'clr'),
            'sql'                     => "int(10) unsigned NOT NULL default '0'"
        ),
    )
);