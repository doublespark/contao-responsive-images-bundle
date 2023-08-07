<?php

declare(strict_types=1);

namespace Doublespark\ContaoResponsiveImagesBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\Image\ImageSizes;

#[AsCallback(table: 'tl_content', target: 'fields.dsImg_sizeMobile.options')]
#[AsCallback(table: 'tl_content', target: 'fields.dsImg_sizeTablet.options')]
#[AsCallback(table: 'tl_content', target: 'fields.dsImg_sizeDesktop.options')]
#[AsCallback(table: 'tl_content', target: 'fields.dsImg_sizeLarge.options')]
#[AsCallback(table: 'tl_ds_image_sizes', target: 'fields.sizeMobile.options')]
#[AsCallback(table: 'tl_ds_image_sizes', target: 'fields.sizeTablet.options')]
#[AsCallback(table: 'tl_ds_image_sizes', target: 'fields.sizeDesktop.options')]
#[AsCallback(table: 'tl_ds_image_sizes', target: 'fields.sizeLarge.options')]
class ImageSizeOptionsCallback
{
    public function __construct(private ImageSizes $imageSizes)
    {
    }

    public function __invoke(): array
    {
        $arrImageSizes = $this->imageSizes->getAllOptions();

        if(isset($arrImageSizes['custom']))
        {
            return $arrImageSizes['custom'];
        }

        return [];
    }
}
