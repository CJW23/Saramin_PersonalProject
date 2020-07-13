<?php


namespace App\Logic;
use Base62\Base62;

class UrlManager
{
    private $base62;

    public function __construct()
    {
        $this->base62 = new Base62();
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

    public function convertUrl($url)
    {
        //http:// 제거 역슬래시(\)처리
        $url = str_replace('http://', "", $url);
        $url = str_replace( 'https://', "", $url);
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
    function urlExists($url = NULL)
    {
        if ($url == NULL) return false;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 400) ? true : false;
    }
}
