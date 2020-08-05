<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\AdminService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    private $adminService;

    public function __construct()
    {
        $this->adminService = app("AdminService");
    }

    /**
     * Path: /admin
     * Method: GET
     * 관리자 통계 페이지 요청
     * @return Application|Factory|View
     */
    public function index()
    {
        try {
            $totalUser = $this->adminService->adminTotalUserCount();
            $totalUrl = $this->adminService->adminTotalUrlCount();
            $totalAccessUrl = $this->adminService->adminTotalUrlAccessCount();
            $dayUrlCount = $this->adminService->adminDayUrlCount();
            $dayUserCount = $this->adminService->adminDayUserCount();
            $dayAccessUrlCount = $this->adminService->adminDayAccessUrlCount();
            return view('admin.adminIndex', [
                "totalUser" => $totalUser,
                "totalUrl" => $totalUrl,
                "totalAccessUrl" => $totalAccessUrl,
                "dayUrlCount" => $dayUrlCount,
                "dayUserCount" => $dayUserCount,
                "dayAccessUrlCount" =>$dayAccessUrlCount
            ]);
        } catch (\Exception $e) {
            return view('error');
        }
    }

    /**
     * Path: /admin/users
     * Method: GET
     * 관리자 유저 관리 페이지 요청
     * @param Request $request
     * @return Application|Factory|View
     */
    public function manageUser(Request $request)
    {
        $info = [
            'keyword' => $request->input('keyword'),
            'search' => $request->input('search')
        ];

        $users = $this->adminService->adminGetUsers($info);
        return view('admin.adminUser', ['users' => $users]);

    }

    /**
     * Path: /admin/urls
     * Method: GET
     * 관리자 URL 관리 페이지 요청
     * @param Request $request
     * @return Application|Factory|View
     */
    public function manageUrl(Request $request)
    {
        $info = [
            'keyword' => $request->input('keyword'),
            'search' => $request->input('url-search')
        ];
        $urls = $this->adminService->adminGetUrls($info);
        return view('admin.adminUrl', ['urls' => $urls]);
    }

    /**
     * Path: /admin/ban
     * Method: GET
     * 관리자 금지 URL 관리 페이지 요청
     * @param Request $request
     * @return Application|Factory|View
     */
    public function manageBanUrl(Request $request)
    {
        $banUrls = $this->adminService->adminGetBanUrls($request->input('url-ban-search'));
        return view('admin.adminBanUrl', ['banUrls' =>$banUrls]);
    }
}
