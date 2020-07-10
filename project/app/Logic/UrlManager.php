<?php


namespace App\Logic;
use Base62\Base62;

class UrlManager
{
    private $base62;

    public function __construct()
    {
        $this->base62 = new Base62();
    }

    public function encodingUrl($url)
    {
        return $this->base62->encode($url);
    }
    public function decodingUrl($url)
    {
        return $this->base62->decode($url);
    }
    public function getQueryString($url)
    {
        $start = strpos($url, '?');
        if($start == 0)
        {
            return "";
        }
        return substr($url, $start);

    }
}
