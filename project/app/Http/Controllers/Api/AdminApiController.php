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

    public function deleteUser($userId)
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

    public function giveAuth($userId)
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

    public function withdrawAuth($userId)
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

    public function deleteUrl($urlId)
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

    public function deleteBanUrl($banUrlId)
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
