<?php


namespace App\DAO;


use App\Model\BanUrl;
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

    public function selectAdminUrls($info)
    {
        if ($info['keyword'] == 'total') {
            return DB::table('urls')
                ->select()
                ->fromSub(function($q) use ($info){
                    $q->from('urls')->leftJoin('users', 'urls.user_id', '=', 'users.id')
                        ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at");
                }, 't')
                ->where(function($q) use ($info){
                    $q->where('t.short_url', 'like', '%' . $info['search'] . '%')
                        ->orWhere('t.original_url', 'like', '%' . $info['search'] . '%')
                        ->orWhere('t.email', 'like', '%' . $info['search'] . '%');
                })
                ->paginate(10);

        } else if($info['keyword'] == null){
            return DB::table('urls')
                ->leftJoin('users', 'urls.user_id', '=', 'users.id')
                ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at")
                ->paginate(10);
        } else{
            return DB::table('urls')
                ->select()
                ->fromSub(function($q) use ($info){
                    $q->from('urls')->leftJoin('users', 'urls.user_id', '=', 'users.id')
                        ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at");
                }, 't')
                ->where($info['keyword'], 'like', '%' . $info['search'] . '%')->paginate(10);
        }


    }

    public function deleteUrl($urlId)
    {
        return DB::table('urls')
            ->delete($urlId);
    }

    public function insertAdminBanUrl(string $url)
    {
        BanUrl::create([
            "url" => $url
        ]);
    }

    public function selectAdminUrl(string $url)
    {
        $checkUrl =
            DB::table('ban_urls')
                ->where('url', '=', $url)
                ->get();
        return count($checkUrl) == 0;
    }

    public function selectAdminBanUrls()
    {
        return DB::table('ban_urls')
            ->paginate(10);
    }

    public function deleteBanUrl($banUrlId)
    {
        DB::table('ban_urls')->delete($banUrlId);
    }

    public function selectAdminUsers($info)
    {
        if ($info['keyword'] == 'total') {
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->where(function($q) use ($info){
                    $q->where('name', 'like', '%' . $info['search'] . '%')
                        ->orWhere('email', 'like', '%' . $info['search'] . '%')
                        ->orWhere('nickname', 'like', '%' . $info['search'] . '%');
                })
                ->paginate(10);

        } else if($info['keyword'] == null){
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->paginate(10);
        } else{
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->where($info['keyword'], 'like', '%' . $info['search'] . '%')
                ->paginate(10);
        }
    }
}

