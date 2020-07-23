<?php

namespace App\Http\Controllers\Api;

use App\DAO\UrlDAO;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\UrlService;
use App\Service\UserMainService;
use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
{
    private $urlService;
    private $userMainService;

    public function __construct()
    {
        define("HTTP", "http://");
        define('DOMAIN', "localhost:8000/");
        $this->urlService = new UrlService();
        $this->userMainService = new UserMainService();
    }

    /*
     * Path: /url/create
     * method: POST
     * url 변환 요청
     */
    //Guest유저 URL은 따로 테이블을 구성할 예정
    public function createUrl(Request $request)
    {
        $info = [
            'url'=>$request->input('url'),
            'userid'=>$request->input('userid')
        ];

        return $this->urlService->makeUrl($info);
    }


    /*
     * Path: /url/query
     * Method: GET
     * 단축 url 입력시 원본 url의 query string 반환
     * */
    public function readUrlQueryString(Request $request)
    {
        return $this->urlService->getQueryString($request->input('url'));
    }

    /*
     * Path: /url/detail/{id}
     * Method: GET
     * 각 url의 세부사항 GET
     */
    public function readUrlDetail($id)
    {
        return $this->userMainService->getUserUrlDetail($id);
    }

    /*
     * Path:/users/urls/create
     * Method: POST
     * user url 변환 요청
     */
    public function createUserUrl(Request $request)
    {
        $info = [
            'url'=>$request->input('url'),
            'userid'=>$request->input('userid'),
            'nameUrl'=>$request->input('nameUrl')
        ];
        return $this->userMainService->makeUserUrl($info);
    }

    /*
     * Path:/users/urls/delete
     * Method: DELETE
     * user url 삭제 요청
     */
    public function deleteUserUrl(Request $request)
    {
        return $this->userMainService->removeUserUrl($request->input('urlIdList'));
    }

    public function totalUserUrlData()
    {
        return $this->userMainService->getUserTotalData();
    }
}
