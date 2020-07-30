<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\Exceptions\UrlException;
use App\Logic\UrlManager;

class MainService
{
    private $urlDAO;
    private $urlManager;

    public function __construct()
    {
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    //원래 URL 획득
    public function getOriginalUrl($path)
    {
        //path -> base62 decoding -> id
        $id = $this->urlManager
            ->decodingUrl($path);
        return $this->urlDAO->selectOriginalUrl($id)[0]->original_url;
    }

    //URL 접속 -> Count 증가
    public function UrlAccess($path)
    {
        //path -> base62 decoding -> id
        $id = $this->urlManager->decodingUrl($path);
        $this->urlDAO->urlAccessTransaction($id);
    }

    /**
     * 비회원 단축 URL 요청
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
     * @param $url
     * @return false|string
     * @throws UrlException
     */
    public function makeUrl($url)
    {
        //http://를 제거한 url
        $originalUrl = $this->urlManager->convertUrl($url['url']);

        //유효나 도메인 체크
        if (!$this->urlManager->urlExists($originalUrl)) {
            throw new UrlException("존재하지 않는 URL");
        }
        //금지된 URL 체크
        if (!$this->urlDAO->getBanUrl(HTTP . $originalUrl)) {
            throw new UrlException("금지된 URL");
        }


        //랜덤 id값을 생성해 중복체크 후 URL 등록
        $shorteningUrl = null;
        $randomId = "";
        while (true) {
            $randomId = $this->urlManager->makeRandomNumber();
            if ($this->urlDAO->checkExistUrlId($randomId)) {
                $shorteningUrl = DOMAIN . $this->urlManager->encodingUrl($randomId);
                break;
            }
        }
        //url 등록
        $this->urlDAO->registerUrl(
            $randomId,
            null,
            HTTP . $originalUrl,
            $this->urlManager->getQueryString($originalUrl),
            $shorteningUrl
        );
        return json_encode([
            "originalUrl" => HTTP . $originalUrl,
            "shortUrl" => $shorteningUrl
        ], JSON_UNESCAPED_SLASHES);
    }
}
