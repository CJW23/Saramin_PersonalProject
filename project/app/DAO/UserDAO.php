<?php


namespace App\DAO;


use Illuminate\Support\Facades\DB;

class UserDAO
{
    public function selectUserUrlList($userId)
    {
        return DB::table("urls")->select('id','original_url', 'short_url')
            ->where('user_id', '=', $userId)
            ->get();
    }
}
