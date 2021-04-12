<?php


namespace App\Service;


use App\Repository\UrlRepository;
use App\Repository\UserRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\BanUrlException;
use App\Exceptions\NotExistException;
use App\Exceptions\UrlException;
use App\Logic\UrlManager;
use App\Model\User;
use Illuminate\Support\Collection;

class UserMainService
{
    private $urlRepository;
    private $urlManager;
    private $userRepository;

    public function __construct(UrlRepository $urlRepository, UrlManager $urlManager, UserRepository $userRepository)
    {
        define("MAX_TRY", 10);
        $this->urlRepository = $urlRepository;
        $this->urlManager = $urlManager;
        $this->userRepository = $userRepository;
    }

    /**
     * 각 유저의 URL 리스트
     * @return array
     */
    public function getUserUrlList()
    {
        //각 유저의 original_url, short_url 가져옴
        return $this->userRepository->selectUserUrlList();
    }

    /**
     * URL의 상세정보
     * @param int $id
     * @return false|string
     */
    public function getUserUrlDetail(int $id)
    {
        return $this->userRepository->selectUserUrlDetail($id);
    }


    /**
     * 유저의 변환된 URL 개수와 Click 횟수
     * @return Collection
     */
    public function getUserTotalData()
    {
        return $this->userRepository->selectUserTotalData();
    }

    /**
     * 유저가 URL등록후 유저 URL 리스트 반환(페이지에 갱신해주기 위해)
     * @param array $url
     * @return array
     * @throws UrlException
     */
    public function makeUserUrl(array $url)
    {
        $originalUrl = $this->urlManager->checkUrlPattern($url['url']);
       // echo $originalUrl;
        if (!$this->urlManager->urlExists($originalUrl)) {
            throw new UrlException("존재하지 않는 URL");
        }

        $domain = $this->urlManager->makeOnlyDomain($originalUrl);
        if (!$this->urlRepository->getBanUrl($domain)) {
            throw new UrlException("금지된 URL");
        }
        //유저 전용
        if (!$this->userRepository->selectUserUrl($originalUrl)) {
            throw new UrlException("이미 존재하는 URL");
        }

        $shortUrl = $this->urlManager->makeShortUrl($this->urlRepository);

        if (!$shortUrl) {
            throw new UrlException("다시 시도해주세요");
        }

        //url 등록
        $this->urlRepository
            ->registerUrl($shortUrl['randomId'], $url['userid'],
                $originalUrl,
                $this->urlManager->getQueryString($originalUrl),
                $shortUrl['shortUrl'],
                empty($url['nameUrl']) ? null : $url['nameUrl']);
        return $this->userRepository->selectUserUrlList();
    }

    /**
     * 일별 유저의 URL 접근 횟수
     * @return false|string
     */
    public function getTotalUrlAccessData()
    {
        return $this->userRepository->selectTotalUrlAccessData();
    }

    /**
     * 유저의 URL 삭제(일괄 삭제)
     * @param array $urlIdList
     * @return array
     */
    public function removeUserUrl(array $urlIdList)
    {
        $this->userRepository->deleteUrl($urlIdList);
        return $this->userRepository->selectUserUrlList();
    }

    /**
     * 특정 URL의 일별 접근 횟수
     * @param int $urlId
     * @return array
     */
    public function getIndividualUrlAccessData(int $urlId)
    {
        return $this->userRepository->selectIndividualUrlAccessData($urlId);
    }

    /**
     * 특정 URL이 링크된 사이트에서 접근한 횟수 통계
     * @param int $urlId
     * @return Collection
     */
    public function getLinkAccessData(int $urlId)
    {
        return $this->userRepository->selectLinkAccessData($urlId);
    }
}
