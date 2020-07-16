<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\DAO\UserDAO;
use App\Logic\UrlManager;

class UserMainService
{
    private $urlDAO;
    private $urlManager;
    private $userDAO;

    public function __construct()
    {
        define('DOMAIN', "http://localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
        $this->userDAO = new UserDAO();
    }

    public function getUserUrlList($userId){
        //각 유저의 original_url, short_url 가져옴
        return $this->userDAO->selectUserUrlList($userId);
    }

}
