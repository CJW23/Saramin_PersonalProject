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

class UserMainService
{
    private $urlRepository;
    private $urlManager;
    private $userRepository;

    public function __construct()
    {
        $this->urlRepository = new UrlRepository();
        $this->urlManager = new UrlManager();
        $this->userRepository = new UserRepository();
    }

    public function getUserUrlList()
    {
        //각 유저의 original_url, short_url 가져옴
        return $this->userRepository->selectUserUrlList();
    }

    public function getUserUrlDetail($id)
    {
        return $this->userRepository->selectUserUrlDetail($id);
    }

    /*
     * 유저의 변환된 URL 개수와 Click 횟수
     */
    public function getUserTotalData()
    {
        return $this->userRepository->selectUserTotalData();
    }

    /*
     * 유저가 URL등록후 유저 URL 리스트 반환(페이지에 갱신해주기 위해)
     */
    public function makeUserUrl($url)
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
        $randomId = "";
        while (true) {
            $randomId = $this->urlManager->makeRandomNumber();
            if ($this->urlRepository->checkExistUrlId($randomId)) {
                $shorteningUrl = DOMAIN . $this->urlManager->encodingUrl($randomId);
                break;
            }
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

    public function getTotalUrlAccessData()
    {
        return $this->userRepository->selectTotalUrlAccessData();
    }

    public function removeUserUrl($urlIdList)
    {
        $this->userRepository->deleteUrl($urlIdList);
        return $this->userRepository->selectUserUrlList();
    }

    public function getIndividualUrlAccessData($urlId)
    {
        return $this->userRepository->selectIndividualUrlAccessData($urlId);
    }

    public function getLinkAccessData($urlId)
    {
        return $this->userRepository->selectLinkAccessData($urlId);
    }
}
