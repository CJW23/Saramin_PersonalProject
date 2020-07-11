<?php


namespace App\Logic;
use Base62\Base62;

class UrlManager
{
    private $base62;

    public function __construct()
    {
        $this->base62 = new Base62();
        define("PATTERN", "/(http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/");
        define("HTTP", "http://");
    }

    public function encodingUrl($url)
    {
        return $this->base62->encode($url);
    }

    public function decodingUrl($url)
    {
        return $this->base62->decode($url);
    }

    public function checkUrlPattern($url)
    {
        //URL 정규식 검사
        if(preg_match(PATTERN, $url) == true)
        {
            return true;
        }
        return false;
    }

    public function convertUrl($url)
    {
        $url = str_replace('http://', "", $url);
        $url = str_replace( 'https://', "awd", $url);
        return $url;
    }
    //원본 url query string 추출
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
