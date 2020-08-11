<?php

namespace App\Http\Controllers\Api;

use App\Repository\UrlRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\BanUrlException;
use App\Exceptions\NotExistException;
use App\Exceptions\UrlException;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Response\UrlApiControllerResponse;
use App\Service\MainService;
use App\Service\UserMainService;
use App\Url;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * URL API Controller
 * Class UrlApiController
 * @package App\Http\Controllers\Api
 */
class UrlApiController extends Controller
{
    private $userMainService;
    private $mainService;
    private $response;

    public function __construct(UserMainService $userMainService, MainService $mainService, UrlApiControllerResponse $urlApiControllerResponse)
    {
        define('DOMAIN', "localhost:8000/");
        $this->userMainService = $userMainService;
        $this->mainService = $mainService;
        $this->response = $urlApiControllerResponse;
    }

    /**
     * Path: /create
     * method: POST
     * 비회원 url 변환 요청
     * @param Request $request
     * @return array|false|string
     */
    public function createUrl(Request $request)
    {
        $info = $request->input('url');
        try {
            return $this->mainService->makeUrl($info);
        } catch (UrlException $e) {
            return $this->response
                ->createUrlResponse($info, __METHOD__, $e->getMessage());
        } catch (\Exception $e) {
            return $this->response
                ->createUrlResponse($info, __METHOD__, $e->getMessage(), "Error 발생");
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
            'nameUrl' => $request->input('nameUrl')];

        try {
            return $this->userMainService->makeUserUrl($info);
        } catch (UrlException $e) {
            return $this->response
                ->createUserUrlResponse( __METHOD__, $e->getMessage());
        } catch (\Exception $e) {
            return $this->response
                ->createUserUrlResponse( __METHOD__, $e->getMessage(), "Error 발생");
        }
    }

    /**
     * Path:/users/urls/delete
     * Method: DELETE
     * user url 삭제 요청
     * @param Request $request
     * @return array|Application|ResponseFactory|Response
     */
    public function deleteUserUrl(Request $request)
    {
        try {
            return $this->userMainService
                ->removeUserUrl($request->input('urlIdList'));
        } catch (\Exception $e) {
            return $this->response
                ->errorResponse(__METHOD__, $e->getMessage());
        }
    }

    /**
     * Path:/users/data/total
     * Method: GET
     * 유저의 URL 전체 접근 횟수와 URL 개수 요청
     * @return Application|ResponseFactory|Response|Collection
     */
    public function totalUserUrlData()
    {
        try {
            return $this->userMainService
                ->getUserTotalData();
        } catch (\Exception $e) {
            return $this->response
                ->errorResponse( __METHOD__, $e->getMessage());
        }


    }

    /**
     * Path: /users/data/url/{urlId}
     * Method: GET
     * 유저의 일주일간 각 URL 일별 접근 횟수 요청
     * @param $urlId
     * @return array|Application|ResponseFactory|Response
     */
    public function individualUserUrlAccessData($urlId)
    {
        try {
            return $this->userMainService
                ->getIndividualUrlAccessData($urlId);
        } catch (\Exception $e) {
            $this->response
                ->errorResponse(__METHOD__, $e->getMessage());
        }
    }

    /**
     * Path: /users/data/link/{urlId}
     * Method: GET
     * 각 ShortURL이 링크된 곳에서 클릭된 횟수 요청
     * @param $urlId
     * @return Application|ResponseFactory|Response|Collection
     */
    public function linkAccessData($urlId)
    {
        try {
            return $this->userMainService
                ->getLinkAccessData($urlId);
        } catch (\Exception $e) {
            $this->response
                ->errorResponse(__METHOD__, $e->getMessage());
        }
    }
}
