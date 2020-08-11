<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\UserMainService;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    private $userMainService;
    public function __construct(UserMainService $userMainService)
    {
        define('DOMAIN', "localhost:8000/");
        define("HTTP", "http://");
        $this->userMainService = $userMainService;
    }

    /**
     * Path: /users
     * Method: GET
     * 유저 대시보드 페이지 요청
     * @param User $user
     * @return Application|Factory|View
     */
    public function index(User $user)
    {
        //사용자의 id를 통해 url 목록 가져옴
        $urlLists = $this->userMainService->getUserUrlList();
        $totalData = $this->userMainService->getUserTotalData();
        $urlAccessData = $this->userMainService->getTotalUrlAccessData();

        return view('user.userIndex', [
            'urlLists'=>$urlLists,
            'totalData'=>$totalData,
            'urlAccessData'=>$urlAccessData
        ]);
    }

    /**
     * Path: /users/setting/info
     * Method: GET
     * 유저 정보 페이지 요청
     * @return Application|Factory|View
     */
    public function userInfo()
    {
        return view('user.userInfo');
    }

    /**
     * Path: /users/setting/info
     * Method: GET
     * 유저 정보 수정 페이지 요청
     * @return Application|Factory|View
     */
    public function userEditInfo()
    {
        return view('user.userEditInfo');
    }

    /**
     * Path: /users/setting/nickname
     * Method: GET
     * 유저 닉네임 수정 페이지 요청
     * @return Application|Factory|View
     */
    public function userNickname()
    {
        return view('user.userNickname');
    }

    /**
     * Path: /users/setting/password
     * Method: GET
     * 유저 패스워드 수정 페이지 요청
     * @return Application|Factory|View
     */
    public function userEditPassword()
    {
        return view('user.userEditPassword');
    }

    /**
     * Path: /users/setting/delete
     * Method: GET
     * 유저 회원 탈퇴 페이지 요청
     * @return Application|Factory|View
     */
    public function userDelete()
    {
        return view('user.userDelete');
    }
}
