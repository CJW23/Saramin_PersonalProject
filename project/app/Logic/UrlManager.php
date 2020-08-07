<?php


namespace App\Logic;
use App\Exceptions\UrlException;
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
     * @param string $id
     * @return mixed
     */
    public function decodingUrl(string $id)
    {
        return $this->base62->decode($id);
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return ($httpcode >= 200 && $httpcode < 400) ? true : false;
    }

    /**
     * 랜덤 id값을 생성해 shortUrl에 들어갈 path 생성
     * @param $urlRepository
     * @return array|bool
     */
    public function makeShortUrl($urlRepository)
    {
        //랜덤 id값을 생성해 중복체크 후 URL 등록
        $shorteningUrl = null;
        $tryCount = 0;
        $randomId = 0;
        while (true) {
            if($tryCount >= MAX_TRY){
                return false;
            }
            $randomId = $this->makeRandomNumber();

            if ($urlRepository->checkExistUrlId($randomId)) {
                $shorteningUrl = DOMAIN . $this->encodingUrl($randomId);
                break;
            }
            $tryCount++;
        }
        return [
            'shortUrl' =>$shorteningUrl,
            'randomId' =>$randomId
        ];
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

    /**
     * 도메인만 추출 ex) http://naver.com/test -> naver.com
     * @param $url
     * @return string|string[]|null
     */
    public function makeOnlyDomain($url)
    {
        return preg_replace("(/([a-zA-Z0-9.-_]+)*)", "",
            preg_replace("(^http:(/*)|https:(/*))", "", $url));
    }

    public function checkUrlPattern($url)
    {
        preg_match("(^http:(/*)|https:(/*))", $url, $matches, PREG_OFFSET_CAPTURE);
        //echo json_encode($matches);
        if($matches == []){
            return "http://".$url;
        }
        return $url;
    }

}
