<?php

namespace App\Http\Controllers\Api;

use App\DAO\UrlDAO;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\UrlService;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    private $urlService;

    public function __construct()
    {
        $this->urlService = new UrlService();
    }

    /*
     * Path: /create
     * method: POST
     * url 변환 요청
     */
    public function createUrl(Request $request)
    {
        $info = [
            'url'=>$request->input('url'),
            'userid'=>$request->input('userid')
        ];
        return $this->urlService->makeUrl($info);
    }

    /*
     * Path: /query
     * Method: GET
     * 단축 url 입력시 원본 url의 query string 반환
     * */
    public function readUrlQueryString(Request $request)
    {
        return $this->urlService->getQueryString($request->input('url'));
    }
}
