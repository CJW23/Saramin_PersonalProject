<?php


namespace App\Logic;
use Base62\Base62;
use DOMDocument;

class UrlManager
{
    private $base62;

    public function __construct()
    {
        $this->base62 = new Base62();
    }

    /**
     * Id값을 Base62로 인코딩
     * @param int $id
     * @return mixed
     */
    public function encodingUrl(int $id)
    {
        return $this->base62->encode($id);
    }

    /**
     * Id값을 Base62로 디코딩
     * @param int $id
     * @return mixed
     */
    public function decodingUrl(string $id)
    {
        return $this->base62->decode($id);
    }

    /**
     * http://를 제거하여 Resource 얻음
     * 이후 URL 유효성 검사에서 //(슬래시) 처리 이슈가 있기에 만든 메소드
     * @param string $url
     * @return string|string[]
     */
    public function convertUrl(string $url)
    {
        $url = str_replace('http://', "", $url);
        $url = str_replace( 'https://', "", $url);
        return $url;
    }

    /**
     * URL에서 Query String 추출
     * 없을 경우 ""를 반환
     * @param string $url
     * @return false|string
     */
    public function getQueryString(string $url)
    {
        $start = strpos($url, '?');
        if($start == 0)
        {
            return "";
        }
        return substr($url, $start);

    }

    /**
     * cUrl을 사용하여 URL 유무 판별
     * 유효한 URL -> TRUE
     * @param string $url
     * @return bool
     */
    public function urlExists(string $url = NULL)
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

    /**
     * Url Id 값으로 사용될 랜덤 숫자 생성
     * @return int
     */
    public function makeRandomNumber()
    {
        $digit = mt_rand(11, 13);
        $num = "";
        for($i=0; $i<$digit; $i++){
            $min = ($i == 0) ? 1:0;
            $num .= mt_rand($min, 9);
        }
        return intval($num);
    }
}
