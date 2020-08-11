<?php


namespace App\Repository;


use App\Model\BanUrl;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AdminRepository
{

    /**
     * 관리자
     * 관리자 창에 출력할 전체 URL 개수
     * @return array
     */
    public function selectAdminTotalUrlCount()
    {
        return DB::select(
            DB::raw(
                "SELECT count(1) AS url_count
                    FROM urls"));
    }

    /**
     * 관리자
     * 관리자 창에 출력할 전체 유저 수
     * @return array
     */
    public function selectAdminTotalUserCount()
    {
        return DB::select(
            DB::raw(
                "SELECT count(1) AS user_count
                    FROM users"));
    }

    /**
     * 관리자
     * 관리자 창에 출력할 오늘 접근된 URL 횟수
     * @return array
     */
    public function selectAdminTotalAccessUrlCount()
    {
        return DB::select(
            DB::raw(
                "SELECT COUNT(1) AS url_access_count
                    FROM access_urls"));
    }

    /**
     * 관리자
     * 관리자 창에 출력할 7일간 일별 생성된 URL 횟수
     * @return false|string
     */
    public function selectAdminDayUrlCount()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(created_at, '%m-%d') AS dates, COUNT(1) AS count
                    FROM urls
                    WHERE date_format(created_at, '%Y-%m-%d') BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
                    GROUP BY dates
                    ORDER BY dates")));
    }

    /**
     * 관리자
     * 관리자 창에 출력할 7일간 일별 생성된 회원
     * @return false|string
     */
    public function selectAdminDayUserCount()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(created_at, '%m-%d') AS dates, COUNT(1) AS count
                    FROM users
                    WHERE date_format(created_at, '%Y-%m-%d') BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
                    GROUP BY dates
                    ORDER BY dates")));
    }

    /**
     * 관리자
     * 유저 삭제
     * @param int $userId
     */
    public function deleteUser(int $userId)
    {
        DB::table("users")
            ->delete($userId);
    }

    /**
     * 관리자
     * 유저 관리자 권한 부여
     * @param int $userId
     */
    public function giveAuth(int $userId)
    {
        DB::table("users")
            ->where('id', $userId)
            ->update(['admin' => 1]);
    }

    /**
     * 관리자
     * 유저 관리자 권한 회수
     * @param int $userId
     */
    public function withdrawAuth(int $userId)
    {
        DB::table("users")
            ->where('id', $userId)
            ->update(['admin' => 0]);
    }

    /**
     * 관리자
     * URL 검색
     * @param array $info
     * @return LengthAwarePaginator
     */
    public function selectAdminUrls(array $info)
    {
        //전체를 검색할 시
        if ($info['keyword'] == 'total') {
            return DB::table('urls')
                ->select()
                ->fromSub(function ($q) use ($info) {
                    $q->from('urls')->leftJoin('users', 'urls.user_id', '=', 'users.id')
                        ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at");
                }, 't')
                ->where(function ($q) use ($info) {
                    $q->where('t.short_url', 'like', '%' . $info['search'] . '%')
                        ->orWhere('t.original_url', 'like', '%' . $info['search'] . '%')
                        ->orWhere('t.email', 'like', '%' . $info['search'] . '%');
                })
                ->paginate(10);
        }
        //페이지 처음 접속시->검색 안함
        else if ($info['keyword'] == null) {
            return DB::table('urls')
                ->leftJoin('users', 'urls.user_id', '=', 'users.id')
                ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at")
                ->paginate(10);
        }
        //키워드 선택후 검색m
        else {
            return DB::table('urls')
                ->select()
                ->fromSub(function ($q) use ($info) {
                    $q->from('urls')->leftJoin('users', 'urls.user_id', '=', 'users.id')
                        ->select('urls.id', 'short_url', DB::raw("ifnull(users.email, 'GUEST') AS email"), "original_url", "count", "urls.created_at");
                }, 't')
                ->where($info['keyword'], 'like', '%' . $info['search'] . '%')->paginate(10);
        }

    }

    /**
     * 관리자
     * URL 삭제
     * @param int $urlId
     * @return int
     */
    public function deleteUrl(int $urlId)
    {
        return DB::table('urls')
            ->delete($urlId);
    }

    /**
     * 관리자
     * 금지 URL 등록
     * @param string $url
     */
    public function insertAdminBanUrl(string $url)
    {
        BanUrl::create([
            "url" => $url
        ]);
    }

    /**
     * 관리자
     * 특정 URL의 금지된 URL 유무 체크
     * 금지 URL 등록시 중복 체크 위해 사용
     * @param string $url
     * @return bool
     */
    public function selectAdminUrl(string $url)
    {
        $checkUrl =
            DB::table('_urls')
                ->where('urlban', '=', $url)
                ->get();
        return count($checkUrl) == 0;
    }

    /**
     * 관리자
     * 금지 URL 검색
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function selectAdminBanUrls(string $search=null)
    {
        return DB::table('ban_urls')
            ->where('url', 'like', '%' . $search . '%')
            ->paginate(10);
    }

    /**
     * 관리자
     * 금지 URL 삭제
     * @param int $banUrlId
     */
    public function deleteBanUrl(int $banUrlId)
    {
        DB::table('ban_urls')->delete($banUrlId);
    }

    /**
     * 관리자
     * 유저 검색
     * @param array $info
     * @return LengthAwarePaginator
     */
    public function selectAdminUsers(array $info)
    {
        if ($info['keyword'] == 'total') {
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->where(function ($q) use ($info) {
                    $q->where('name', 'like', '%' . $info['search'] . '%')
                        ->orWhere('email', 'like', '%' . $info['search'] . '%')
                        ->orWhere('nickname', 'like', '%' . $info['search'] . '%');
                })
                ->paginate(10);

        } else if ($info['keyword'] == null) {
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->paginate(10);
        } else {
            return DB::table("users")
                ->where('id', '!=', auth()->user()->id)
                ->where($info['keyword'], 'like', '%' . $info['search'] . '%')
                ->paginate(10);
        }
    }

    /**
     * 관리자
     * 일별 URL 접근 횟수
     * @return false|string
     */
    public function selectAdminDayAccessUrlCount()
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT date_format(access_time, '%m-%d') AS dates, COUNT(1) AS count
                        FROM access_urls
                        WHERE date_format(access_time, '%Y-%m-%d') BETWEEN (NOW() - INTERVAL 7 DAY) AND NOW()
                        GROUP BY dates
                        ORDER BY dates")));
    }
}

