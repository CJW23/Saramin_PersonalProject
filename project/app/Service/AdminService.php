<?php


namespace App\Service;


use App\Repository\AdminRepository;
use App\Exceptions\AlreadyExistException;
use App\Exceptions\NotExistException;
use App\Logic\UrlManager;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AdminService
{
    private $adminRepository;
    private $urlManager;

    public function __construct()
    {
        define("HTTP", "http://");
        $this->adminRepository = app("AdminRepository");
        $this->urlManager = app("UrlManager");
    }

    /**
     * 모든 URL 개수
     * @return array
     */
    public function adminTotalUrlCount()
    {
        return $this->adminRepository->selectAdminTotalUrlCount();
    }

    /**
     * 모든 유저 수
     * @return array
     */
    public function adminTotalUserCount()
    {
        return $this->adminRepository->selectAdminTotalUserCount();
    }

    /**
     * 모든 URL 접근 수
     * @return array
     */
    public function adminTotalUrlAccessCount()
    {
        return $this->adminRepository->selectAdminTotalAccessUrlCount();
    }

    /**
     * 일별 URL등록 개수
     * @return false|string
     */
    public function adminDayUrlCount()
    {
        return $this->adminRepository->selectAdminDayUrlCount();
    }

    /**
     * 일별 회원가입 수
     * @return false|string
     */
    public function adminDayUserCount()
    {
        return $this->adminRepository->selectAdminDayUserCount();
    }

    /**
     * 유저 삭제
     * @param int $userId
     */
    public function adminRemoveUser(int $userId)
    {
        $this->adminRepository->deleteUser($userId);
    }

    /**
     * 유저 검색
     * @param array $info
     * @return LengthAwarePaginator
     */
    public function adminGetUsers(array $info)
    {
        return $this->adminRepository->selectAdminUsers($info);
    }

    /**
     * 유저 관리자 권한 부여
     * @param int $userId
     */
    public function adminGiveAuth(int $userId)
    {
        $this->adminRepository->giveAuth($userId);
    }

    /**
     * 관리자 권한 회수
     * @param int $userId
     */
    public function adminWithdrawAuth(int $userId)
    {
        $this->adminRepository->withdrawAuth($userId);
    }

    /**
     * URL 검색
     * @param array $info
     * @return LengthAwarePaginator
     */
    public function adminGetUrls(array $info)
    {
        return $this->adminRepository->selectAdminUrls($info);
    }

    /**
     * URL 삭제
     * @param int $urlId
     */
    public function adminRemoveUrl(int $urlId)
    {
        $this->adminRepository->deleteUrl($urlId);
    }

    /**
     * 금지 URL 등록
     * @param $url
     * @throws AlreadyExistException
     * @throws NotExistException
     */
    public function adminRegisterBanUrl($url)
    {
        $originalUrl = $this->urlManager->makeOnlyDomain($url);
        if (!$this->urlManager->urlExists($originalUrl)) {
            //echo $originalUrl;
            throw new NotExistException("존재하지 않는 URL");
        }
        if (!$this->adminRepository->selectAdminUrl($originalUrl)) {
            //echo $originalUrl;
            throw new AlreadyExistException("이미 존재하는 URL");
        }
        $this->adminRepository->insertAdminBanUrl($originalUrl);
    }

    /**
     * 금지 URL 검색
     * @param string $search
     * @return LengthAwarePaginator
     */
    public function adminGetBanUrls($search=null)
    {
        return $this->adminRepository->selectAdminBanUrls($search);
    }

    /**
     * 금지 URL 삭제
     * @param int $banUrlId
     */
    public function adminRemoveBanUrl(int $banUrlId)
    {
        $this->adminRepository->deleteBanUrl($banUrlId);
    }

    /**
     * 일별 URL 접근 횟수
     * @return false|string
     */
    public function adminDayAccessUrlCount()
    {
        return $this->adminRepository->selectAdminDayAccessUrlCount();
    }
}
