<?php


namespace App\Service;


use App\Repository\UrlRepository;
use App\Repository\UserRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\BanUrlException;
use App\Exceptions\NotExistException;
use App\Exceptions\UrlException;
use App\Logic\UrlManager;
use App\User;
use Illuminate\Support\Collection;

class UserMainService
{
    private $urlRepository;
    private $urlManager;
    private $userRepository;

    public function __construct()
    {
        define("MAX_TRY", 10);
        $this->urlRepository = app("UrlRepository");
        $this->urlManager = app("UrlManager");
        $this->userRepository = app("UserRepository");
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
        //http://를 제거한 url
        $originalUrl = $this->urlManager->convertUrl($url['url']);

        //유효 도메인 체크
        if (!$this->urlManager->urlExists($originalUrl) ) {
            throw new UrlException("존재하지 않는 URL");
        }
        //금지된 URL 체크
        if (!$this->urlRepository->getBanUrl(HTTP . $originalUrl)) {
            throw new UrlException("금지된 URL");
        }
        //이미 등록 URL 체크
        if (!$this->userRepository->selectUserUrl(HTTP . $originalUrl)) {
            throw new UrlException("이미 존재하는 URL");
        }

        //랜덤 id값을 생성해 중복체크 후 URL 등록
        $shorteningUrl = null;
        $tryCount = 0;
        $randomId = 0;
        while (true) {
            if($tryCount >= MAX_TRY){
                throw new UrlException("다시 시도해주십시오");
            }
            $randomId = $this->urlManager->makeRandomNumber();

            if ($this->urlRepository->checkExistUrlId($randomId)) {
                $shorteningUrl = DOMAIN . $this->urlManager->encodingUrl($randomId);
                break;
            }
            $tryCount++;
        }

        //url 등록
        if ($url['nameUrl'] == "")       //URL 이름을 입력했을시
        {
            $this->urlRepository->registerUrl(
                $randomId, $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl);
        } else                            //URL 이름을 입력안했을시
        {
            $this->urlRepository->registerUrl(
                $randomId, $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl, $url['nameUrl']);
        }

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
