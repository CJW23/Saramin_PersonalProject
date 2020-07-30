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
    public function checkExistUrlId($id)
    {
        return count(DB::table("urls")->where('id', '=', $id)->get()) == 0;
    }
    public function registerUrl($id, $userId, $originalUrl, $queryString, $shortUrl, $nameUrl=null)
    {
        Url::create([
            "id" => $id,
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

    public function urlAccessTransaction($id)
    {
        DB::transaction(function () use ($id) {
            AccessUrl::create([
                'url_id' =>$id
            ]);
            DB::table('urls')->where('id', '=', $id)->increment('count');
        });
    }
    /*public function createUrlAccessTime($id)
    {
        DB::transaction(function (){

        });
        AccessUrl::create([
            'url_id' =>$id
        ]);
    }

    public function updateUrlCount($id)
    {
        DB::table('urls')->where('id', '=', $id)->increment('count');
    }*/

    public function getBanUrl($url)
    {
        return count(DB::table("ban_urls")->where('url', '=', $url)->get()) == 0;
    }
}
