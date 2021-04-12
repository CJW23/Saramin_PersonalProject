<?php


namespace App\Repository;



use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * 각 유저의 URL 리스트
     * @return array
     */
    public function selectUserUrlList()
    {
        return
            DB::select(
                DB::raw(
                    "SELECT id, short_url, user_id, ifnull(name_url, original_url) as name, count
                        FROM urls
                        WHERE user_id = :userId"), ['userId' => auth()->user()->id]);
    }

    /**
     * 유저의 URL 유무 판별
     * 중복 등록 방지
     * @param string $url
     * @return bool
     */
    public function selectUserUrl(string $url)
    {
        return count(DB::table("urls")
                ->where('original_url', $url)
                ->where('user_id', auth()->user()->id)
                ->get()) == 0;
    }

    /**
     * 유저가 등록한 URL의 개수, URL을 접근한 횟수
     * @return Collection
     */
    public function selectUserTotalData()
    {
        return $result = DB::table("urls")
            ->select(DB::raw("COUNT(*) as total_num, SUM(count) as total_sum"))
            ->where('user_id', auth()->user()->id)
            ->get();
    }

    /**
     * URL의 상세정보
     * @param int $urlId
     * @return false|string
     */
    public function selectUserUrlDetail(int $urlId)
    {
        return json_encode(
            DB::select(
                DB::raw(
                    "SELECT id, short_url, user_id, original_url, ifnull(name_url, original_url) as name_url, created_at, count
                        FROM urls
                        WHERE id = :urlId"), ['urlId' => $urlId])
        );
    }

    /**
     * 일별 모든 URL 접근 횟수
     * @return false|string
     */
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
                        date_format(access_time, '%Y-%m-%d') between (NOW() - INTERVAL 7 DAY) AND NOW()
                        GROUP BY dates
                        ORDER BY dates"), ['userid' => auth()->user()->id]));
    }

    /**
     * 특정 URL의 일별 접근 횟수
     * @param int $urlId
     * @return array
     */
    public function selectIndividualUrlAccessData(int $urlId)
    {
        return
            DB::select(
                DB::raw(
                    "SELECT date_format(access_time, '%m-%d') AS dates, SUM(1) AS count
                        FROM access_urls
                        WHERE access_urls.url_id = :urlid AND
                        date_format(access_time, '%Y-%m-%d') between (NOW() - INTERVAL 7 DAY) AND NOW()
                        GROUP BY dates
                        ORDER BY dates;"), ['urlid' => $urlId]);
    }

    /**
     * 유저의 이름 변경
     * @param string $name
     */
    public function updateUserInfo(string $name)
    {
        DB::table("users")
            ->where('id', auth()->user()->id)
            ->update(['name' => $name]);
    }

    /**
     * 유저의 닉네임 변경
     * @param string $nickname
     */
    public function updateUserNickname(string $nickname)
    {
        DB::table("users")
            ->where('id', auth()->user()->id)
            ->update(['nickname' => $nickname]);
    }

    /**
     * 유저의 패스워드 변경
     * @param string $password
     */
    public function updatePassword(string $password)
    {
        User::find(auth()->user()->id)->update(['password' => Hash::make($password)]);
    }

    /**
     * 유저 회원탈퇴
     */
    public function deleteUser()
    {
        DB::table("users")
            ->delete(auth()->user()->id);
    }

    /**
     * 유저의 URL 삭제(다중 삭제)
     * @param array $urlIdList
     */
    public function deleteUrl(array $urlIdList)
    {
        DB::table("urls")->where('user_id', auth()->user()->id)->whereIn('id', $urlIdList, 'and')
            ->delete();
    }

    /**
     * 링크된 URL 통계
     * @param int $urlId
     * @return Collection
     */
    public function selectLinkAccessData(int $urlId)
    {
        return DB::table("access_urls")
            ->select(DB::raw("IFNULL(before_url, 'Direct') AS before_url, COUNT(1) AS cnt"))
            ->where('url_id',$urlId)
            ->groupBy('before_url')->get();
    }

    /**
     * 닉네임 중복 판별
     * @param $nickname
     * @return bool
     */
    public function checkUserNickname($nickname)
    {
        return count(DB::table("users")
            ->where("nickname", '=', $nickname)
            ->get()) == 0;

    }

}
