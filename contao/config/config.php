<?php

use Contao\System;
use Symfony\Component\HttpFoundation\Request;

/**
 * Models
 */
$GLOBALS['TL_MODELS']['tl_ds_image_sizes'] = 'Doublespark\ContaoResponsiveImagesBundle\Models\DsImageSizesModel';

// Add responsive image element
$GLOBALS['TL_CTE']['media']['responsive_image'] = 'Doublespark\ContaoResponsiveImagesBundle\Elements\ContentResponsiveImage';

/**
 * BACK END MODULES
 */
$GLOBALS['BE_MOD']['system']['tl_ds_image_sizes'] = [
    'tables' => ['tl_ds_image_sizes']
];