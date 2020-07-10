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

    public function registerUrl($userId, $originalUrl, $queryString)
    {
        Url::create([
            "user_id" => $userId,
            "original_url" => $originalUrl,
            "query_string" => $queryString
        ]);
    }
}
