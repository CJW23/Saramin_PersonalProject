<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotExistException;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\AdminService;
use Illuminate\Http\Request;

class AdminApiController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    /**
     * Path: /admin/users/{userId}
     * Method: DELETE
     * 관리자가 유저 삭제 요청
     * @param int $userId
     * @return string[]
     */
    public function deleteUser(int $userId)
    {
        try {
            $this->adminService->adminRemoveUser($userId);
            return [
                'result' => 'true'
            ];
        } catch (\Exception $e) {
            return [
                'result' => 'false'
            ];
        }
    }

    /**
     * Path: /admin/users/give-auth/{userId}
     * Method: PUT
     * 관리자가 일반 유저에게 관리자 권한 요청
     * @param int $userId
     * @return string[]
     */
    public function giveAuth(int $userId)
    {
        try {
            $this->adminService->adminGiveAuth($userId);
            return [
                'result' => 'true'
            ];
        } catch (\Exception $e) {
            echo $e;
            return [
                'result' => 'false'
            ];
        }
    }

    /**
     * Path: /admin/users/withdraw-auth/{userId}
     * Method: PUT
     * 관리자가 일반 유저의 관리자 권한 해제 요청
     * @param int $userId
     * @return string[]
     */
    public function withdrawAuth(int $userId)
    {
        try {
            $this->adminService->adminWithdrawAuth($userId);
            return [
                'result' => 'true'
            ];
        } catch (\Exception $e) {
            echo $e;
            return [
                'result' => 'false'
            ];
        }
    }

    /**
     * Path: /admin/urls/{urlId}
     * Method: DELETE
     * 관리자가 URL 삭제 요청
     * @param int $urlId
     * @return string[]
     */
    public function deleteUrl(int $urlId)
    {
        try {
            $this->adminService->adminRemoveUrl($urlId);
            return [
                'result' => 'true'
            ];
        } catch (\Exception $e) {
            return [
                'result' => 'false'
            ];
        }
    }

    /**
     * Path: /admin/ban
     * Method: POST
     * 관리자가 금지 URL 등록 요청
     * @param Request $request
     * @return array|string[]
     */
    public function createBanUrl(Request $request)
    {
        $url = $request->input('url');
        try {
            $this->adminService->adminRegisterUrl($url);
            return [
                'result' => 'true'
            ];
        } catch (AlreadyExistException $e) {
            return [
                'result' => 'false',
                'msg' => $e->getMessage()
            ];
        } catch (NotExistException $e) {
            return [
                'result' => 'false',
                'msg' => $e->getMessage()
            ];
        }
    }

    /**
     * Path: /admin/ban/{banUrlId}
     * Method: DELETE
     * 관리자가 금지 URL 삭제 요청
     * @param int $banUrlId
     * @return array|string[]
     */
    public function deleteBanUrl(int $banUrlId)
    {
        try {
            $this->adminService->adminRemoveBanUrl($banUrlId);
            return[
                'result' => 'true'
            ];
        } catch (\Exception $e){
            return[
                'result'=>'false',
                'msg'=>$e->getMessage()
            ];
        }
    }
}
