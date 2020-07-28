<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
}
