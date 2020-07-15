<?php


namespace App\DAO;


use Illuminate\Support\Facades\DB;

class UserDAO
{
    public function selectUserUrlList($userId)
    {
        return DB::table("urls")
            ->where('user_id', '=', $userId)
            ->get();
    }
}
