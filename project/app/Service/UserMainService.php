<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\DAO\UserDAO;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\BanUrlException;
use App\Exceptions\NotExistException;
use App\Exceptions\UrlException;
use App\Logic\UrlManager;
use App\User;

class UserMainService
{
    private $urlDAO;
    private $urlManager;
    private $userDAO;

    public function __construct()
    {
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
        $this->userDAO = new UserDAO();
    }

    public function getUserUrlList()
    {
        //각 유저의 original_url, short_url 가져옴
        return $this->userDAO->selectUserUrlList();
    }

    public function getUserUrlDetail($id)
    {
        return $this->userDAO->selectUserUrlDetail($id);
    }

    /*
     * 유저의 변환된 URL 개수와 Click 횟수
     */
    public function getUserTotalData()
    {
        return $this->userDAO->selectUserTotalData();
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
        if (!$this->urlDAO->getBanUrl(HTTP . $originalUrl)) {
            throw new UrlException("금지된 URL");
        }
        //이미 등록 URL 체크
        if (!$this->userDAO->selectUserUrl(HTTP . $originalUrl)) {
            throw new UrlException("이미 존재하는 URL");
        }

        //id의 최대값+1을 base62 인코딩
        $shorteningUrl = DOMAIN . $this->urlManager->encodingUrl(
                $this->urlDAO->selectMaxId() + 1);

        //url 등록
        if ($url['nameUrl'] == "")       //URL 이름을 입력했을시
        {
            $this->urlDAO->registerUrl(
                $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl);
        } else                            //URL 이름을 입력안했을시
        {
            $this->urlDAO->registerUrl(
                $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl, $url['nameUrl']);
        }

        return $this->userDAO->selectUserUrlList();
    }

    public function getTotalUrlAccessData()
    {
        return $this->userDAO->selectTotalUrlAccessData();
    }

    public function removeUserUrl($urlIdList)
    {
        $this->userDAO->deleteUrl($urlIdList);
        return $this->userDAO->selectUserUrlList();
    }

    public function getIndividualUrlAccessData($urlId)
    {
        return $this->userDAO->selectIndividualUrlAccessData($urlId);
    }
}
