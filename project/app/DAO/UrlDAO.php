<?php


namespace App\DAO;


use Illuminate\Support\Facades\DB;

class UrlDAO
{
    public function MaxIdDAO()
    {
        return DB::table("urls")->select("id")->max("id");
    }
}
