<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Service\MainService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Request;


class MainController extends Controller
{
    private $mainService;

    public function __construct()
    {
        define("HTTP", "http://");
        $this->mainService = new MainService();
    }

    /**
     * Path: /
     * Method: GET
     * Index 페이지 요청
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('main.index');
    }

    /**
     * Path: /{path}
     * Method: GET
     * 단축 URL 접근시 원본 URL로 Redirect 요청
     * @param string $path
     * @return Application|RedirectResponse|Redirector
     */
    public function originalUrlRedirect(string $path)
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
