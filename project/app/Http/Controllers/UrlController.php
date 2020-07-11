<?php


namespace App\Http\Controllers;


use App\DAO\UrlDAO;
use App\Logic\UrlManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UrlController extends Controller
{
    private  $urlDAO;
    private $urlManager;

    public function __construct()
    {
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    /*
     * url 변환 요청
     * user_id, url
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
    */
    public function createUrl(Request $request)
    {
        //사용자로부터 받은 url을 http://를 포함시켜 저장
        $originalUrl = $this->urlManager->convertUrl($request->input("url"));
        //echo $originalUrl;
        if($this->urlManager->checkUrlPattern($originalUrl))
        {
            //id의 최대값+1을 base62 인코딩
            $shorteningUrl =
                stripslashes("http://localhost:8000/".$this->urlManager->encodingUrl($this->urlDAO->selectMaxId() + 1));

            //url 등록
            $this->urlDAO->registerUrl(
                $request->input('userid'),
                $originalUrl,
                $this->urlManager->getQueryString($originalUrl));

            return json_encode([
                "shortUrl" => $shorteningUrl
            ], JSON_UNESCAPED_SLASHES);
        }
        return json_encode([
            "shortUrl" => "false",
        ]);
    }
}
