<?php


namespace App\DAO;


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
}
