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
        define('DOMAIN', 'http://localhost:8000/');
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    //인덱스 페이지
    public function index()
    {
        return view('main.index');
    }

    /*
     * url 변환 요청
     * user_id, url
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
    */
    public function createUrl(Request $request)
    {
        //id의 최대값+1을 base62 인코딩
        $shorteningUrl = $this->urlManager->encodingUrl($this->urlDAO->MaxIdDAO() + 1);

        //사용자로부터 받은 url
        $originalUrl = $request->input("url");

        //url 등록
        Url::create([
            "user_id" => $request->input('userid'),
            "original_url" => $originalUrl,
            "query_string" => $this->urlManager->getQueryString($originalUrl)
        ]);

        return DOMAIN.$shorteningUrl;
    }

    public function originalUrlRedirect(Request $request)
    {
        $id = $this->urlManager->decodingUrl($request->path());
        echo $id;
        $originalUrl = DB::table('urls')->select('original_url')->where('id','=', $id)->get();
        echo $originalUrl;
    }
}
