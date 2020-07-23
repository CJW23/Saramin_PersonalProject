<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\UserMainService;
use App\User;
use Illuminate\Http\Request;

class UserMainController extends Controller
{
    private $userMainService;
    public function __construct()
    {
        define('DOMAIN', "localhost:8000/");
        define("HTTP", "http://");
        $this->userMainService = new UserMainService();
    }

    public function index(User $user)
    {
        //로그인 정보 확인
        abort_unless(auth()->user()->own($user), 403);

        //사용자의 id를 통해 url 목록 가져옴
        $urlLists = $this->userMainService->getUserUrlList();
        $totalData = $this->userMainService->getUserTotalData();
        $urlAccessData = $this->userMainService->getUserUrlAccessData();

        return view('user.userIndex', [
            'urlLists'=>$urlLists,
            'totalData'=>$totalData,
            'urlAccessData'=>$urlAccessData
        ]);
    }

    public function userInfo()
    {
        return view('user.userInfo');
    }
    public function userEditInfo()
    {
        return view('user.userEditInfo');
    }
    public function userNickname()
    {
        return view('user.userNickname');
    }
    public function userEditPassword()
    {
        return view('user.userEditPassword');
    }
    public function userDelete()
    {
        return view('user.userDelete');
    }
}
