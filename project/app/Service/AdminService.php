<?php


namespace App\Service;


use App\DAO\AdminRepository;

class AdminService
{
    private $adminRepository;

    public function __construct()
    {
        $this->adminRepository = new AdminRepository();
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

    public function adminGiveAuth($userId)
    {
        $this->adminRepository->giveAuth($userId);
    }

    public function adminWithdrawAuth($userId)
    {
        $this->adminRepository->withdrawAuth($userId);
    }
}
