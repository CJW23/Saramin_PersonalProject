<?php


namespace App\DAO;


use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserDAO
{
    public function selectUserUrlList()
    {
        return
            DB::select(
                DB::raw(
                    "SELECT id, short_url, user_id, ifnull(name_url, original_url) as name, count
                        FROM urls
                        WHERE user_id = :userId"), ['userId' => auth()->user()->id]);
    }

    public function selectUserUrl($url)
    {
        $result = DB::table("urls")->where('original_url', $url)->where('user_id', auth()->user()->id)->get();
        return count($result) == 0;
    }

    public function selectUserTotalData()
    {
        return $result = DB::table("urls")
            ->select(DB::raw("COUNT(*) as total_num, SUM(count) as total_sum"))
            ->where('user_id', auth()->user()->id)
            ->get();
    }

    public function selectUserUrlDetail($urlId)
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT id, short_url, user_id, original_url, ifnull(name_url, original_url) as name_url, created_at, count
                        FROM urls
                        WHERE id = :urlId"), ['urlId' => $urlId])
        );
    }

    public function selectTotalUrlAccessData()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(access_time, '%m-%d') AS dates, SUM(1) AS count
                        FROM access_urls, users, urls
                        WHERE  users.id = :userid AND
                        users.id = urls.user_id AND
                        urls.id = access_urls.url_id AND
                        date_format(access_time, '%Y-%m-%d') between (NOW() - INTERVAL 1 MONTH) AND NOW()
                        GROUP BY dates"), ['userid' => auth()->user()->id]));
    }

    public function selectIndividualUrlAccessData($urlId)
    {
        return
            DB::select(
                DB::raw(
                    "SELECT date_format(access_time, '%m-%d') AS dates, SUM(1) AS count
                        FROM access_urls
                        WHERE access_urls.url_id = :urlid AND
                        date_format(access_time, '%Y-%m-%d') between (NOW() - INTERVAL 1 MONTH) AND NOW()
                        GROUP BY dates;"), ['urlid' => $urlId]);
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

    public function updatePassword($password)
    {
        User::find(auth()->user()->id)->update(['password' => Hash::make($password)]);
    }

    public function deleteUser()
    {
        DB::table("users")
            ->delete(auth()->user()->id);
    }

    public function deleteUrl($urlIdList)
    {
        DB::table("urls")->where('user_id', auth()->user()->id)->whereIn('id', $urlIdList, 'and')
            ->delete();
    }

}
