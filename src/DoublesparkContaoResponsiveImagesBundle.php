<?php

namespace Doublespark\ContaoResponsiveImagesBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Configures the responsive images bundle
 *
 * @author Jamie Devine
 */
class DoublesparkContaoResponsiveImagesBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}