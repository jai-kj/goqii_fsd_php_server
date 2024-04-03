<?php

require_once __DIR__ . '/../config/Messages.php';
require_once __DIR__ . '/../models/User.php';

class UserController
{
    private $conn;
    private User $userModel;

    public function __construct($conn)
    {
        $this->conn = $conn;
        $this->userModel = new User($this->conn);
    }

    public function getAllUsers()
    {
        $users = $this->userModel->getAllUsers();
        interceptEcho(Messages::USERS_LIST_SUCCESS, 200, $users ? $users : array());
    }

    public function getUserById(string $id)
    {
        if ($id === null || !is_string($id)) {
            interceptEcho(Messages::INVALID_USER_ID, 400, null, Messages::INVALID_USER_ID);
            return;
        }

        $user = $this->userModel->getUserById($id);
        if ($user)
            interceptEcho(Messages::USER_FETCH_SUCCESS, 200, $user);
        else
            interceptEcho(Messages::USER_NOT_FOUND, 404, null, Messages::USER_NOT_FOUND);
    }
}
