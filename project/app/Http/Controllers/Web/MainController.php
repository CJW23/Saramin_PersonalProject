<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\MainService;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Request;


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
        $link = request()->headers->get('referer');
        //echo URL::previous();
        $this->mainService->UrlAccess($path, $link);
        //echo json_encode(request()->headers->all());
        //return view('error');
        return redirect(
            $this->mainService->getOriginalUrl($path));
    }
}
