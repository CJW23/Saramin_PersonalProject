<?php


namespace App\Service;


use App\Repository\UrlRepository;
use App\Exceptions\UrlException;
use App\Logic\UrlManager;

class MainService
{
    private $urlRepository;
    private $urlManager;

    public function __construct()
    {

        /*$this->urlRepository = app("UrlRepository");
        $this->urlManager = app("UrlManager");*/
        $this->urlRepository = new UrlRepository();
        $this->urlManager = new UrlManager();
    }

    /**
     * Path를 추출하여 Base62 디코딩하여 Id값을 얻어 원래 URL 획득
     * @param string $path
     * @return mixed
     */
    public function getOriginalUrl(string $path)
    {
        $id = $this->urlManager
            ->decodingUrl($path);
        return $this->urlRepository->selectOriginalUrl($id)[0]->original_url;
    }


    /**
     * 단축 URL 접근후 횟수 증가, 링크 등록, 접근 시간 등록
     * @param $path
     * @param $link
     */
    public function UrlAccess($path, $link)
    {
        //path -> base62 decoding -> id
        $id = $this->urlManager->decodingUrl($path);
        $this->urlRepository->urlAccessTransaction($id, $link);
        //이전 링크가 있다면 디비에 저장
    }

    /**
     * 비회원 단축 URL 요청
     * Table 최대 id 값에 1을 더한 값을 Base62 인코딩
     * @param $originalUrl
     * @return false|string
     * @throws UrlException
     */
    public function makeUrl($originalUrl)
    {

        if (!$this->urlManager->urlExists($originalUrl)) {
            throw new UrlException("존재하지 않는 URL");
        }
        //http와 path를 제거한 domain ex) naver.com
        $domain = $this->urlManager->makeOnlyDomain($originalUrl);
        if (!$this->urlRepository->getBanUrl($domain)) {
            throw new UrlException("금지된 URL");
        }
        $shortUrl = $this->urlManager->makeShortUrl($this->urlRepository);
        //shortUrl이 생성이 실패
        if (!$shortUrl) {
            throw new UrlException("다시 시도해주세요");
        }

        $this->urlRepository->registerUrl(
            $shortUrl['randomId'],
            null,
            $originalUrl,
            $this->urlManager->getQueryString($originalUrl),
            $shortUrl['shortUrl']
        );

        return json_encode([
            "originalUrl" => $originalUrl,
            "shortUrl" => $shortUrl['shortUrl']
        ], JSON_UNESCAPED_SLASHES);
    }
}
