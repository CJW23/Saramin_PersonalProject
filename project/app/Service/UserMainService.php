<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\DAO\UserDAO;
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
        return $this->userDAO->selectUserUrlList(auth()->id());
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
        //url 존재 여부
        if (!$this->userDAO->selectUserUrl(HTTP . $originalUrl))
        {
            return json_encode([
                'result' => 'already exist'
            ]);
        }
        //유효 도메인 체크
        if ($this->urlManager->urlExists($originalUrl))
        {
            //id의 최대값+1을 base62 인코딩
            $shorteningUrl = DOMAIN . $this->urlManager->encodingUrl(
                    $this->urlDAO->selectMaxId() + 1);

            //url 등록
            if($url['nameUrl'] == "")       //URL 이름을 입력했을시
            {
                $this->urlDAO->registerUrl(
                    $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl);
            }
            else                            //URL 이름을 입력안했을시
            {
                $this->urlDAO->registerUrl(
                    $url['userid'], HTTP . $originalUrl, $this->urlManager->getQueryString($originalUrl), $shorteningUrl, $url['nameUrl']);
            }
            return $this->userDAO->selectUserUrlList(auth()->user()->id);
        }
        //url이 유효하지 않음
        return json_encode([
            'result' => 'not exist'
        ]);
    }

    public function removeUserUrl($urlIdList)
    {
        $this->userDAO->deleteUrl($urlIdList);
        return $this->userDAO->selectUserUrlList(auth()->user()->id);
    }
}
