<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SamePasswordException;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\Service\UserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mosquitto\Exception;

class UserController extends Controller
{
    private $userService;

    public function __construct()
    {
        define('SAME_PASSWORD', 1);
        define('WRONG_PASSWORD', 2);
        define('CORRECT_PASSWORD', 3);
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
        $curPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        try {
            $request->validate([
                'current_password' => ['required', new MatchOldPassword()],
                'new_password' => ['required', 'string', 'min:8', 'max:15', 'regex:/(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            if($curPassword == $newPassword){
                throw new SamePasswordException("기존 패스워드와 동일합니다");
            }
            $this->userService->changeUserPassword($newPassword);
        }catch (SamePasswordException $e){      //변경할 패스워드와 기존 패스워드 같을때
            return [
                'type'=>SAME_PASSWORD,
                'msg'=>$e->getMessage()
            ];
        } catch (\Exception $e){
            return [
                'type'=>WRONG_PASSWORD,
                'msg'=>"비밀번호를 확인하세요"
            ];
        }
        return [
            'type'=>CORRECT_PASSWORD,
            'msg'=>'변경 완료'
        ];
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
