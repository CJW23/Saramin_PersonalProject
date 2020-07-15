<?php


namespace App\Service;


use App\DAO\UrlDAO;
use App\Logic\UrlManager;

class MainService
{
    private $urlDAO;
    private $urlManager;

    public function __construct()
    {
        define('DOMAIN', "http://localhost:8000/");
        $this->urlDAO = new UrlDAO();
        $this->urlManager = new UrlManager();
    }

    public function getOriginalUrl($path)
    {
        //URL Path를 디코딩하여 id값 추출트
        $id = $this->urlManager
            ->decodingUrl($path);
        return $this->urlDAO->selectOriginalUrl($id)[0]->original_url;
    }

}
