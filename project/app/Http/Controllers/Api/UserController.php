<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $request->validate([
            'current_password' => ['required', new MatchOldPassword()],
            'new_password' => ['required', 'string', 'min:8', 'max:15', 'regex:/(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/'],
            'new_confirm_password' => ['same:new_password'],
        ]);

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->input('new_password'))]);
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
