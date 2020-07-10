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
        $shorteningUrl =
            $this->urlManager->encodingUrl($this->urlDAO->selectMaxId() + 1);

        //사용자로부터 받은 url을 http://를 포함시켜 저장
        $originalUrl = $this->urlManager->convertUrl($request->input("url"));

        if($this->urlManager->checkUrlPattern($originalUrl))
        {
            //url 등록
            $this->urlDAO->registerUrl(
                $request->input('userid'),
                $originalUrl,
                $this->urlManager->getQueryString($originalUrl));

            return DOMAIN.$shorteningUrl;
        }
        return "false";
    }

    public function originalUrlRedirect(Request $request)
    {
        //URL Path를 디코딩하여 id값 추출
        $id = $this->urlManager->decodingUrl($request->path());
        echo $id;
        $originalUrl = DB::table('urls')->select('original_url')->where('id','=', $id)->get();
        //echo $originalUrl[0]->original_url;
        return redirect("http://".$originalUrl[0]->original_url);
    }
}
