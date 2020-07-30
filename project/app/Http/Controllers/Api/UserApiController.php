<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SamePasswordException;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\Service\UserSettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserApiController extends Controller
{
    private $userService;

    public function __construct()
    {
        define('SAME_PASSWORD', 1);
        define('WRONG_PASSWORD', 2);
        define('CORRECT_PASSWORD', 3);
        $this->userService = new UserSettingService();
    }

    /**
     * Path: /users/info
     * Method: PUT
     * 회원 정보 수정 요청
     * @param Request $request
     */
    public function editInfoRequest(Request $request)
    {
        $name = $request->input('name');
        $this->userService->changeUserInfo($name);
    }

    /**
     * Path: /users/setting/password
     * Method: PUT
     * 패스워드 수정 요청
     * @param Request $request
     * @return array
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

    /**
     * Path: /users/setting/nickname
     * Method: PUT
     * 닉네임 수정 요청
     * @param Request $request
     */
    public function editNicknameRequest(Request $request)
    {
        $nickname = $request->input('nickname');
        $this->userService->changeUserNickname($nickname);
    }

    /**
     * Path: /users/setting/delete
     * Method: DELETE
     * 회원 탈퇴 요청
     * @param Request $request
     * @return string
     */
    public function dropUserRequest(Request $request)
    {
        $curPassword = $request->input('current_password');
        if(Hash::check($curPassword, auth()->user()->getAuthPassword()))
        {
            $this->userService->dropUser();
            Auth::logout();
            Session::flush();
            return 'true';
        }
        return 'false';
    }
}
