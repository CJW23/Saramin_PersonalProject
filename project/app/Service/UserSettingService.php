<?php


namespace App\Service;


use App\Repository\UserRepository;

class UserSettingService
{
    private $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function changeUserInfo($name)
    {
        $this->userRepository->updateUserInfo($name);
    }

    public function changeUserNickname($nickname)
    {
        validator(['awd'=>'awd']);
        $this->userRepository->updateUserNickname($nickname);
    }

    public function changeUserPassword($password)
    {
        $this->userRepository->updatePassword($password);
    }

    public function dropUser()
    {
        $this->userRepository->deleteUser();
    }
}
