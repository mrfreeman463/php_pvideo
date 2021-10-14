<?php

namespace App\Http\Controllers\Parsers;

use App\Helpers\XVideo;

class XVideoController
{
    private $xvideo;

    public function __construct()
    {
        $this->xvideo = XVideo::getInstance();
    }

    public function parseFile()
    {
        $this->xvideo->parse();
    }
}
