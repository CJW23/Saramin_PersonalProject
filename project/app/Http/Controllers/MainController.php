<?php

namespace App\Http\Controllers;

use App\DAO\UrlDAO;
use App\Logic\UrlManager;
use App\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    private  $urlDAO;
    private $urlManager;

    public function __construct()
    {
        define('DOMAIN', "http://localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    //인덱스 페이지
    public function index()
    {
        return view('main.index');
    }

    //shortening url 원본 url 리다이렉
    public function originalUrlRedirect(Request $request)
    {
        //URL Path를 디코딩하여 id값 추출트
        $id = $this->urlManager
            ->decodingUrl($request->path());

        $originalUrl = $this->urlDAO
            ->selectOriginalUrl($id);
        return redirect($originalUrl[0]->original_url);
    }
}
