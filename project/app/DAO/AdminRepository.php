<?php


namespace App\DAO;


use App\User;
use Illuminate\Support\Facades\DB;

class AdminRepository
{

    /**
     * 관리자 창에 출력할 전체 URL 개수
     */
    public function selectAdminTotalUrlCount()
    {
        return DB::select(
            DB::raw(
                "SELECT count(1) AS url_count
                    FROM urls"));
    }

    /**
     * 관리자 창에 출력할 전체 유저 수
     */
    public function selectAdminTotalUserCount()
    {
        return DB::select(
            DB::raw(
                "SELECT count(1) AS user_count
                    FROM users"));
    }

    /**
     * 관리자 창에 출력할 오늘 접근된 URL 횟수
     */
    public function selectAdminTotalAccessUrlCount()
    {
        return DB::select(
            DB::raw(
                "SELECT COUNT(1) AS url_access_count
                    FROM access_urls"));
    }

    /**
     * 관리자 창에 출력할 7일간 일별 생성된 URL 횟수
     */
    public function selectAdminDayUrlCount()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(created_at, '%m-%d') AS dates, COUNT(1) AS count
                    FROM urls
                    WHERE date_format(created_at, '%Y-%m-%d') BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
                    GROUP BY dates")));
    }

    /**
     * 관리자 창에 출력할 7일간 일별 생성된 회원
     */
    public function selectAdminDayUserCount()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(created_at, '%m-%d') AS dates, COUNT(1) AS count
                    FROM users
                    WHERE date_format(created_at, '%Y-%m-%d') BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
                    GROUP BY dates")));
    }

    public function deleteUser($userId)
    {
        DB::table("users")
            ->delete($userId);
    }

    public function giveAuth($userId)
    {
        DB::table("users")
            ->where('id', $userId)
            ->update(['admin' => 1]);
    }

    public function withdrawAuth($userId)
    {
        DB::table("users")
            ->where('id', $userId)
            ->update(['admin' => 0]);
    }
}
