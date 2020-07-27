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
}
