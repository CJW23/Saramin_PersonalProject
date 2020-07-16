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
        $this->userMainService = new UserMainService();
    }

    public function index(User $user)
    {
        //로그인 정보 확인
        abort_unless(auth()->user()->own($user), 403);

        //사용자의 id를 통해 url 목록 가져옴
        $urlLists = $this->userMainService->getUserUrlList();
        return view('user.userIndex', [
            'urlLists'=>$urlLists
        ]);
    }

    public function userInfo(User $user)
    {
        abort_unless(auth()->user()->own($user), 403);
        return view('user.userInfo');
    }
}
