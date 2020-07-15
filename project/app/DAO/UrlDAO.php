<?php


namespace App\DAO;


use App\Url;
use Illuminate\Support\Facades\DB;

class UrlDAO
{
    public function selectMaxId()
    {
        return DB::table("urls")->select("id")->max("id");
    }

    public function registerUrl($userId, $originalUrl, $queryString, $shortUrl)
    {
        Url::create([
            "user_id" => $userId,
            "original_url" => $originalUrl,
            "query_string" => $queryString,
            "short_url" => $shortUrl
        ]);
    }

    public function selectOriginalUrl($id)
    {
        return DB::table('urls')
            ->select('original_url')
            ->where('id','=', $id)
            ->get();
    }

    public function selectQueryStringUrl($id)
    {
        return DB::table('urls')
            ->select('query_string')
            ->where('id', '=',  $id)
            ->get();
    }
}
