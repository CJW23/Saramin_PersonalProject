<?php

namespace App\Http\Controllers\Api;

use App\Repository\UrlRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\BanUrlException;
use App\Exceptions\NotExistException;
use App\Exceptions\UrlException;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\MainService;
use App\Service\UserMainService;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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

    /**
     * Path: /url/create
     * method: POST
     * url 변환 요청
     * @param Request $request
     * @return array|false|string
     */
    public function createUrl(Request $request)
    {
        $info = [
            'url' => $request->input('url'),
            'userid' => $request->input('userid')
        ];

        try {
            return $this->mainService->makeUrl($info);
        } catch (UrlException $e) {
            return [
                'shortUrl' => 'false',
                'originalUrl' => $info['url'],
                'msg' => $e->getMessage()
            ];
        }
    }

    /**
     * Path: /url/detail/{id}
     * Method: GET
     * 각 url의 세부사항 GET
     * @param $id
     * @return false|string
     */
    public function readUrlDetail($id)
    {
        return $this->userMainService->getUserUrlDetail($id);
    }

    /**
     * Path:/users/urls/create
     * Method: POST
     * user url 변환 요청
     * @param Request $request
     * @return array
     */
    public function createUserUrl(Request $request)
    {
        $info = [
            'url' => $request->input('url'),
            'userid' => $request->input('userid'),
            'nameUrl' => $request->input('nameUrl')
        ];

        try {
            return $this->userMainService->makeUserUrl($info);
        } catch (UrlException $e) {
            return [
                'rst' => 'false',
                'msg' => $e->getMessage()
            ];
        }

    }

    /**
     * Path:/users/urls/delete
     * Method: DELETE
     * user url 삭제 요청
     * @param Request $request
     * @return array
     */
    public function deleteUserUrl(Request $request)
    {
        return $this->userMainService->removeUserUrl($request->input('urlIdList'));
    }

    /**
     * Path:/users/data/total
     * Method: GET
     * 유저의 URL 전체 접근 횟수와 URL 개수 요청
     * @return Collection
     */
    public function totalUserUrlData()
    {
        return $this->userMainService->getUserTotalData();
    }

    /**
     * Path: /users/data/url/{urlId}
     * Method: GET
     * 유저의 일주일간 각 URL 일별 접근 횟수 요청
     * @param $urlId
     * @return array
     */
    public function individualUserUrlAccessData($urlId)
    {
        return $this->userMainService->getIndividualUrlAccessData($urlId);
    }

    /**
     * Path: /users/data/link/{urlId}
     * Method: GET
     * 각 ShortURL이 링크된 곳에서 클릭된 횟수 요청
     * @param $urlId
     * @return Collection
     */
    public function linkAccessData($urlId)
    {
        return $this->userMainService->getLinkAccessData($urlId);
    }
}
