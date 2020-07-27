<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = new AdminService();
    }

    public function index()
    {
        try {
            $totalUser = $this->adminService->adminTotalUserCount();
            $totalUrl = $this->adminService->adminTotalUrlCount();
            $totalAccessUrl = $this->adminService->adminTotalUrlAccessCount();
            return view('admin.adminIndex', [
                "totalUser" => $totalUser,
                "totalUrl" => $totalUrl,
                "totalAccessUrl" => $totalAccessUrl
            ]);
        } catch (\Exception $e){
            return view('error');
        }
    }
}
