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

    //원래 URL 획득
    public function getOriginalUrl($path)
    {
        //path -> base62 decoding -> id
        $id = $this->urlManager
            ->decodingUrl($path);
        return $this->urlDAO->selectOriginalUrl($id)[0]->original_url;
    }

    //URL 접속 -> Count 증가
    public function updateUrlCount($path)
    {
        //path -> base62 decoding -> id
        $id = $this->urlManager
            ->decodingUrl($path);
        $this->urlDAO->updateUrlCount($id);
    }
}
