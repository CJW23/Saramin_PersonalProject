<?php


namespace App\DAO;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDAO
{
    public function selectUserUrlList($userId)
    {
        return DB::table("urls")->select('id','original_url', 'short_url', 'count')
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function selectUserUrl($url)
    {
        $result = DB::table("urls")->where('original_url', $url)->get();
        return count($result) == 0;
    }

    public function selectUserTotalData()
    {
        return $result = DB::table("urls")
            ->select(DB::raw("COUNT(*) as total_num, SUM(count) as total_sum"))
            ->where('user_id', auth()->user()->id)
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

    public function updatePassword($password){
        User::find(auth()->user()->id)->update(['password' => Hash::make($password)]);
    }

    public function deleteUser()
    {
        DB::table("users")
            ->delete(auth()->user()->id);
    }

    public function deleteUrl($urlIdList)
    {
        DB::table("urls")->where('user_id',auth()->user()->id)->whereIn('id',$urlIdList, 'and')
            ->delete();
    }
}
