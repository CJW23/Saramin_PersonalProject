<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\SamePasswordException;
use App\Exceptions\WrongPasswordException;
use App\Http\Controllers\Controller;
use App\Response\UserControllerResponse;
use App\Rules\MatchOldPassword;
use App\Service\UserSettingService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


/**
 *
 * Class UserApiController
 * @package App\Http\Controllers\Api
 */
class UserApiController extends Controller
{
    private $userService;
    private $response;

    public function __construct()
    {
        define('SAME_PASSWORD', 1);
        define('WRONG_PASSWORD', 2);
        define('CORRECT_PASSWORD', 3);
        $this->userService = new UserSettingService();
        $this->response = new UserControllerResponse();
    }

    /**
     * Path: /users/setting/info
     * Method: PUT
     * 회원 이름 수정 요청
     * @param Request $request
     */
    public function editInfo(Request $request)
    {
        try {
            $name = $request->input('name');
            $this->userService->changeUserInfo($name);
            return $this->response
                ->editInfoResponse('true', __METHOD__);
        } catch (\Exception $e) {
            return $this->response
                ->editInfoResponse('false', __METHOD__, $e->getMessage());
        }
    }

    /**
     * Path: /users/setting/password
     * Method: PUT
     * 패스워드 수정 요청
     * @param Request $request
     * @return array
     */
    public function editPassword(Request $request)
    {
        $curPassword = $request->input('current_password');
        $newPassword = $request->input('new_password');

        try {
            $request->validate([
                'current_password' => ['required', new MatchOldPassword()],
                'new_password' => ['required', 'string', 'min:8', 'max:15', 'regex:/(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/'],
                'new_confirm_password' => ['same:new_password'],
            ]);
            if ($curPassword == $newPassword) {
                throw new SamePasswordException("기존 패스워드와 동일합니다");
            }
            $this->userService->changeUserPassword($newPassword);
            return $this->response
                ->editPasswordResponse(CORRECT_PASSWORD, '변경 완료', __METHOD__);
        } catch (SamePasswordException $e) {
            return $this->response
                ->editPasswordResponse(SAME_PASSWORD, $e->getMessage(), __METHOD__, $e->getMessage());
        } catch (\Exception $e) {
            return $this->response
                ->editPasswordResponse(WRONG_PASSWORD, '에러 잠시 후 다시 시도', __METHOD__, $e->getMessage());
        }
    }

    /**
     * Path: /users/setting/nickname
     * Method: PUT
     * 닉네임 수정 요청
     * @param Request $request
     */
    public function editNickname(Request $request)
    {
        try {
            $nickname = $request->input('nickname');
            $this->userService->changeUserNickname($nickname);
            return $this->response
                ->editNicknameResponse('true', __METHOD__);
        } catch (\Exception $e) {
            return $this->response
                ->editNicknameResponse('false', __METHOD__, $e->getMessage());
        }
    }

    public function checkNickname(Request $request)
    {
        $nickname = $request->input('nickname');
        //중복된 닉네임이 없을경우
        if ($this->userService->checkUserNickName($nickname)) {
            return $this->response
                ->checkNicknameResponse('true');
        } else {
            return $this->response
                ->checkNicknameResponse('false');
        }
    }

    /**
     * Path: /users/setting/delete
     * Method: DELETE
     * 회원 탈퇴 요청
     * @param Request $request
     * @return Application|ResponseFactory|Response|string|string[]
     */
    public function dropUser(Request $request)
    {
        try {
            $curPassword = $request->input('current_password');
            if (!Hash::check($curPassword, auth()->user()->getAuthPassword())) {
                throw new WrongPasswordException("비밀번호를 확인하세요");
            }
            $this->userService->dropUser();
            Auth::logout();
            Session::flush();
            return $this->response
                ->dropUserResponse('true', __METHOD__);
        } catch (WrongPasswordException $e) {
            return $this->response
                ->dropUserResponse('wrong', __METHOD__);
        } catch (\Exception $e) {
            return $this->response
                ->dropUserResponse('false', __METHOD__, $e->getMessage());
        }
    }
}
