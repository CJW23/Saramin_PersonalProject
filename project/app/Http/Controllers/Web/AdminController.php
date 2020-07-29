<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $dayUrlCount = $this->adminService->adminDayUrlCount();
            $dayUserCount = $this->adminService->adminDayUserCount();
            return view('admin.adminIndex', [
                "totalUser" => $totalUser,
                "totalUrl" => $totalUrl,
                "totalAccessUrl" => $totalAccessUrl,
                "dayUrlCount" => $dayUrlCount,
                "dayUserCount" => $dayUserCount
            ]);
        } catch (\Exception $e) {
            return view('error');
        }
    }

    public function manageUser(Request $request)
    {
        $info = [
            'keyword' => $request->input('keyword'),
            'search' => $request->input('search')
        ];
        try {
            $users = $this->adminService->adminGetUsers($info);
            return view('admin.adminUser', ['users' => $users]);
        } catch (\Exception $e) {
            echo $e;
            return view('error');
        }
    }

    public function manageUrl(Request $request)
    {
        $info = [
            'keyword' => $request->input('keyword'),
            'search' => $request->input('url-search')
        ];
        try {
            $urls = $this->adminService->adminGetUrls($info);
            return view('admin.adminUrl', ['urls' => $urls]);
        } catch (\Exception $e) {
            echo $e;
            return view('error');
        }
    }

    public function manageBanUrl(Request $request)
    {
        $info = [
            'keyword' => $request->input('keyword'),
            'search' => $request->input('search')
        ];
        try {
            $banUrls = $this->adminService->adminGetBanUrls($info);
            return view('admin.adminBanUrl', ['banUrls' =>$banUrls]);
        } catch (\Exception $e) {
            return view('error');
        }
    }
}
