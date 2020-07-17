<?php


namespace App\DAO;


use Illuminate\Support\Facades\DB;

class UserDAO
{
    public function selectUserUrlList($userId)
    {
        return DB::table("urls")->select('id','original_url', 'short_url', 'count')
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function updateUserInfo($name)
    {
        DB::table("users")
            ->where('id', auth()->user()->id)
            ->update(['name' => $name]);
    }

    public function updateUserNickname($nickname)
    {
        DB::table("users")
            ->where('id', auth()->user()->id)
            ->update(['nickname' => $nickname]);
    }
}
