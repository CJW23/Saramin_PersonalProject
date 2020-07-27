<?php


namespace App\DAO;


use App\Model\AccessUrl;
use App\Url;
use Illuminate\Support\Facades\DB;

class UrlDAO
{
    public function selectMaxId()
    {
        return DB::table("urls")->select("id")->max("id");
    }

    public function registerUrl($userId, $originalUrl, $queryString, $shortUrl, $nameUrl=null)
    {
        Url::create([
            "user_id" => $userId,
            "original_url" => $originalUrl,
            "query_string" => $queryString,
            "short_url" => $shortUrl,
            "name_url" => $nameUrl
        ]);
    }

    public function selectOriginalUrl($id)
    {
        return DB::table('urls')
            ->select('original_url')
            ->where('id','=', $id)
            ->get();
    }

    public function createUrlAccessTime($id)
    {
        AccessUrl::create([
            'url_id' =>$id
        ]);
    }

    public function updateUrlCount($id)
    {
        DB::table('urls')->where('id', '=', $id)->increment('count');
    }
}
