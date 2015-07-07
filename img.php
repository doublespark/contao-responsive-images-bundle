<?php

/**
 * Initialize the system
 */
define('TL_MODE', 'FE');
require '../../../system/initialize.php';

class ResponsiveImage extends Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
        // Get values from request
        $width  = \Input::get('w');
        $height = \Input::get('h');
        $image  = \Input::get('img');
        $mode   = \Input::get('m');

        // Get the crop mode
        switch($mode)
        {
            case 'c':
                $mode = 'center_center';
                break;
            case 'p':
                $mode = 'proportional';
                break;
            case '':
                $mode = 'proportional';
                break;
        }

        // See if a height has been defined
        if($height == '')
        {
            $height = 0;
        }

        // Generate the image
        $image = TL_ROOT . '/' . Image::get($image, $width, $height, $mode);

        // Send the image to the browser
        $this->sendImage($image);
    }

    /**
     * Outputs an image to the browser
     * @param  String $filename
     */
    protected function sendImage($filename) {

        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (in_array($extension, array('png', 'gif', 'jpeg'))) {

            header("Content-Type: image/".$extension);

        } else {

            header("Content-Type: image/jpeg");
        }

        $cache = 60*60*24*7;

        header("Cache-Control: private, max-age=".$cache);
        header('Expires: '.gmdate('D, d M Y H:i:s', time()+$cache).' GMT');
        header('Content-Length: '.filesize($filename));
        readfile($filename);
        exit();
    }
}

$RI = new ResponsiveImage();
$RI->run();

?>