<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\Logic\UrlManager;

class UserMainService
{
    private $urlDAO;
    private $urlManager;

    public function __construct()
    {
        define('DOMAIN', "http://localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }
}
