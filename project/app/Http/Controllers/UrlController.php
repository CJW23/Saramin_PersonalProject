<?php

namespace App\Http\Controllers;

use App\DAO\UrlDAO;
use App\Logic\UrlManager;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    private $urlDAO;
    private $urlManager;

    public function __construct()
    {
        define('DOMAIN', "http://localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    /*
     * Path: /create
     * method: POST
     * url 변환 요청
     * user_id, url
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
    */
    public function createUrl(Request $request)
    {
        //http://를 제거한 url
        $originalUrl = $this->urlManager->convertUrl($request->input("url"));

        //유효나 도메인 체크
        if($this->urlManager->urlExists($originalUrl))
        {
            //id의 최대값+1을 base62 인코딩
            $shorteningUrl = DOMAIN.$this->urlManager
                        ->encodingUrl($this->urlDAO
                            ->selectMaxId() + 1);

            //url 등록
            $this->urlDAO->registerUrl(
                    $request->input('userid'),
                    HTTP.$originalUrl,
                    $this->urlManager
                        ->getQueryString($originalUrl));

            return json_encode([
                "shortUrl" => $shorteningUrl
            ], JSON_UNESCAPED_SLASHES);
        }
        return json_encode([
            "shortUrl" => "false",
        ]);
    }

    /*
     * Path: /query
     * Method: GET
     * 단축 url 입력시 원본 url의 query string 반환
     * */
    public function getUrlQueryString(Request $request)
    {
        //url : localhost:8000/{encoding id}
        $splitUrl = explode('/', $request->input("url"));

        //인코딩 된 id 추출
        $id = $this->urlManager
            ->decodingUrl(array_pop($splitUrl));
        return json_encode([
            "query" => $this->urlDAO
                ->selectQueryStringUrl($id)
        ]);
    }
}
