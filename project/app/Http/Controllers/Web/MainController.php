<?php

namespace App\Http\Controllers\Web;

use App\DAO\UrlDAO;
use App\Http\Controllers\Controller;
use App\Logic\UrlManager;
use App\Service\MainService;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    private $mainService;

    public function __construct()
    {
        define("HTTP", "http://");
        $this->mainService = new MainService();
    }

    //인덱스 페이지
    public function index()
    {
        return view('main.index');
    }

    //shortening url 원본 url 리다이렉트
    public function originalUrlRedirect($path)
    {
        //접근 Count증가 및 시간 등록
        $this->mainService->createUrlAccess($path);
        //echo $path;
        return redirect($this->mainService
            ->getOriginalUrl($path));
    }
}
