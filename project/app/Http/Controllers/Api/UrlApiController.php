<?php

namespace App\Http\Controllers\Api;

use App\DAO\UrlDAO;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\MainService;
use App\Service\UserMainService;
use App\Url;
use Illuminate\Http\Request;

class UrlApiController extends Controller
{
    private $userMainService;
    private $mainService;

    public function __construct()
    {
        define("HTTP", "http://");
        define('DOMAIN', "localhost:8000/");
        $this->userMainService = new UserMainService();
        $this->mainService = new MainService();
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

        return $this->mainService->makeUrl($info);
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

    /*
     * Path:/users/data/total
     * Method: GET
     * user의 URL 전체 접근 횟수와 URL 개수 요청
     */
    public function totalUserUrlData()
    {
        return $this->userMainService->getUserTotalData();
    }

    /*
     * Path: /users/data/url/{urlId}
     * Method: GET
     * userdml 각 URL의 일주일전까지의 일별 접근 횟수 요청
     */
    public function individualUserUrlData($urlId)
    {
        return $this->userMainService->getIndividualUrlAccessData($urlId);
    }
}
