<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    /*
     * 회원 정보 수정 Request
     * Path: /users/info
     * Method: PUT
     */
    public function editInfoRequest(Request $request)
    {
        $name = $request->input('name');
        $this->userService->changeUserInfo($name);
    }

    /*
     * 패스워드 수정 Request
     * Path: /users/setting/password
     * Method: PUT
     */
    public function editPasswordRequest(Request $request)
    {
        
    }
    /*
     * 닉네임 수정 Request
     * Path: /users/setting/nickname
     */
    public function editNicknameRequest(Request $request)
    {
        $nickname = $request->input('nickname');
        $this->userService->changeUserNickname($nickname);
    }
}
