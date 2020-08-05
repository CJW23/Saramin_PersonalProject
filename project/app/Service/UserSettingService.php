<?php


namespace App\Service;


use App\Repository\UserRepository;

class UserSettingService
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = app("UserRepository");
    }

    /**
     * 유저 이름 변경
     * @param string $name
     */
    public function changeUserInfo(string $name)
    {
        $this->userRepository->updateUserInfo($name);
    }

    /**
     * 유저 닉네임 변경
     * @param string $nickname
     */
    public function changeUserNickname(string $nickname)
    {
        $this->userRepository->updateUserNickname($nickname);
    }

    /**
     * 유저 패스워드 변경
     * @param string $password
     */
    public function changeUserPassword(string $password)
    {
        $this->userRepository->updatePassword($password);
    }

    /**
     * 유저 회원 탈퇴
     */
    public function dropUser()
    {
        $this->userRepository->deleteUser();
    }

    public function checkUserNickName($nickname)
    {
        return $this->userRepository->checkUserNickname($nickname);
    }
}
