<?php


namespace App\Service;


use App\DAO\AdminRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotExistException;
use App\Logic\UrlManager;
use Exception;

class AdminService
{
    private $adminRepository;
    private $urlManager;

    public function __construct()
    {
        define("HTTP", "http://");
        $this->adminRepository = new AdminRepository();
        $this->urlManager = new UrlManager();
    }

    public function adminTotalUrlCount()
    {
        return $this->adminRepository->selectAdminTotalUrlCount();
    }

    public function adminTotalUserCount()
    {
        return $this->adminRepository->selectAdminTotalUserCount();
    }

    public function adminTotalUrlAccessCount()
    {
        return $this->adminRepository->selectAdminTotalAccessUrlCount();
    }

    public function adminDayUrlCount()
    {
        return $this->adminRepository->selectAdminDayUrlCount();
    }

    public function adminDayUserCount()
    {
        return $this->adminRepository->selectAdminDayUserCount();
    }

    public function adminRemoveUser($userId)
    {
        $this->adminRepository->deleteUser($userId);
    }

    public function adminGetUsers($info)
    {
        return $this->adminRepository->selectAdminUsers($info);
    }

    public function adminGiveAuth($userId)
    {
        $this->adminRepository->giveAuth($userId);
    }

    public function adminWithdrawAuth($userId)
    {
        $this->adminRepository->withdrawAuth($userId);
    }

    public function adminGetUrls($info)
    {
        return $this->adminRepository->selectAdminUrls($info);
    }

    public function adminRemoveUrl($urlId)
    {
        $this->adminRepository->deleteUrl($urlId);
    }

    public function adminRegisterUrl($url)
    {
        $originalUrl = $this->urlManager->convertUrl($url);
        if (!$this->urlManager->urlExists($originalUrl)) {
            throw new NotExistException("존재하지 않는 URL");
        }
        if (!$this->adminRepository->selectAdminUrl(HTTP . $originalUrl)) {
            throw new AlreadyExistException("이미 존재하는 URL");
        }
        $this->adminRepository->insertAdminBanUrl(HTTP . $originalUrl);
    }

    public function adminGetBanUrls($search)
    {
        return $this->adminRepository->selectAdminBanUrls($search);
    }

    public function adminRemoveBanUrl($banUrlId)
    {
        $this->adminRepository->deleteBanUrl($banUrlId);
    }

    public function adminDayAccessUrlCount()
    {
        return $this->adminRepository->selectAdminDayAccessUrlCount();
    }
}
