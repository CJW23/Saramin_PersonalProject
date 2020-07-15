<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\Logic\UrlManager;

class UrlService
{
    private $urlDAO;
    private $urlManager;

    public function __construct()
    {
        define('DOMAIN', "localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    /*
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
    */
    public function makeUrl($url)
    {
        //http://를 제거한 url
        $originalUrl = $this->urlManager->convertUrl($url['url']);

        //유효나 도메인 체크
        if($this->urlManager->urlExists($originalUrl))
        {
            //id의 최대값+1을 base62 인코딩
            $shorteningUrl = DOMAIN.$this->urlManager
                    ->encodingUrl($this->urlDAO
                            ->selectMaxId() + 1);

            //url 등록
            $this->urlDAO->registerUrl(
                $url['userid'],
                HTTP.$originalUrl,
                $this->urlManager
                    ->getQueryString($originalUrl),
                $shorteningUrl
            );

            return json_encode([
                "originalUrl" => HTTP.$originalUrl,
                "shortUrl" => $shorteningUrl
            ], JSON_UNESCAPED_SLASHES);
        }
        return json_encode([
            "originalUrl" => HTTP.$originalUrl,
            "shortUrl" => "false",
        ]);
    }

    public function getQueryString($url)
    {
        //url : localhost:8000/{encoding id}
        $splitUrl = explode('/', $url);

        //인코딩 된 id 추출
        $id = $this->urlManager
            ->decodingUrl(array_pop($splitUrl));
        return json_encode([
            "query" => $this->urlDAO
                ->selectQueryStringUrl($id)
        ]);
    }
}
