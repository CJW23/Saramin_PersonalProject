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
        $urlLists = $this->userMainService->getUserUrlList($user->id);
        return view('user.userIndex', [
            'urlLists'=>$urlLists
        ]);
    }
}
