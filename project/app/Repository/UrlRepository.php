<?php


namespace App\Repository;


use App\Model\AccessUrl;
use App\Url;
use Illuminate\Support\Facades\DB;

class UrlRepository
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

    public function urlAccessTransaction($id, $link)
    {
        DB::transaction(function () use ($link, $id) {
            AccessUrl::create([
                'url_id' =>$id,
                'before_url'=>$link
            ]);
            DB::table('urls')->where('id', '=', $id)->increment('count');
        });
    }

    public function getBanUrl($url)
    {
        return count(DB::table("ban_urls")->where('url', '=', $url)->get()) == 0;
    }
}
