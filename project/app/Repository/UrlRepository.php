<?php


namespace App\Repository;


use App\Model\AccessUrl;
use App\Url;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UrlRepository
{
    /**
     * 랜덤값으로 생성된 Id 값 존재 유무
     * 중복 방지
     * @param int $id
     * @return bool
     */
    public function checkExistUrlId(int $id)
    {
        return count(DB::table("urls")->where('id', '=', $id)->get()) == 0;
    }

    /**
     * URL 등록
     * @param int $id
     * @param int $userId
     * @param string $originalUrl
     * @param string $queryString
     * @param string $shortUrl
     * @param string|null $nameUrl
     */
    public function registerUrl(int $id, $userId, string $originalUrl, string $queryString, string $shortUrl, string $nameUrl=null)
    {
        Url::create([
            "id" => $id,
            "user_id" => $userId,
            "original_url" => $originalUrl,
            "query_string" => $queryString,
            "short_url" => $shortUrl,
            "name_url" => $nameUrl
        ]);
    }

    /**
     * 원본 URL 찾기
     * Redirect를 위해
     * @param int $id
     * @return Collection
     */
    public function selectOriginalUrl(int $id)
    {
        return DB::table('urls')
            ->select('original_url')
            ->where('id','=', $id)
            ->get();
    }

    /**
     * 단축 URL 접속 횟수, 시간, 링크된 사이트 저장
     * @param int $id
     * @param string $link
     */
    public function urlAccessTransaction(int $id, string $link = null)
    {
        DB::transaction(function () use ($link, $id) {
            AccessUrl::create([
                'url_id' =>$id,
                'before_url'=>$link
            ]);
            DB::table('urls')->where('id', '=', $id)->increment('count');
        });
    }

    /**
     * 금지된 URL 검색
     * 중복 검사
     * @param string $url
     * @return bool
     */
    public function getBanUrl(string $url)
    {
        return count(DB::table("ban_urls")->where('url', '=', $url)->get()) == 0;
    }
}
