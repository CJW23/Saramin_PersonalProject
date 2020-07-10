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
        //입력받은 url에 http://가 포함
        if(substr($url, 0, 7) == "http://"
            || substr($url, 0, 8) == "https://")
        {
            return $url;
        }
        return HTTP.$url;
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
