<?php


namespace App\Service;


use App\DAO\UserDAO;

class UserService
{
    private $userDAO;
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    public function changeUserInfo($name)
    {
        $this->userDAO->updateUserInfo($name);
    }

    public function changeUserNickname($nickname)
    {
        $this->userDAO->updateUserNickname($nickname);
    }

}
