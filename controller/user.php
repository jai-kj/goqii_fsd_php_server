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
        if (empty($id) || !is_string($id)) {
            interceptEcho(Messages::INVALID_USER_ID, 400, null, Messages::INVALID_USER_ID);
            return;
        }

        $user = $this->userModel->getUserById($id);
        if ($user)
            interceptEcho(Messages::USER_FETCH_SUCCESS, 200, $user);
        else
            interceptEcho(Messages::USER_NOT_FOUND, 404, null, Messages::USER_NOT_FOUND);
    }

    public function insertUser($reqBody)
    {
        if (!isset($reqBody['name']) || !isset($reqBody['email']) || !isset($reqBody['dob'])) {
            interceptEcho(Messages::INCOMPLETE_USER_INSERT_BODY, 400, null, Messages::INCOMPLETE_USER_INSERT_BODY);
            return;
        }

        $name = trim($reqBody['name']);
        if (!preg_match('/^[a-zA-Z][a-zA-Z0-9 ]*$/', $name)) {
            interceptEcho(Messages::INVALID_USER_NAME, 400, null, Messages::INVALID_USER_NAME);
            return;
        }

        $email = trim($reqBody['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            interceptEcho(Messages::INVALID_USER_EMAIL, 400, null, Messages::INVALID_USER_EMAIL);
            return;
        }

        $dob = date('Y-m-d', strtotime(trim($reqBody['dob'])));
        $currentDate = date('Y-m-d');
        if (!$dob || $dob > $currentDate) {
            interceptEcho(Messages::INVALID_USER_DOB, 400, null, Messages::INVALID_USER_DOB);
            return;
        }

        try {
            $success = $this->userModel->insertUser($name, $email, $dob);
            if ($success) {
                interceptEcho(Messages::USER_INSERT_SUCCESS, 200);
                // TODO: Send set password email to newly added user
            } else {
                interceptEcho(Messages::USER_INSERT_FAILURE, 500, null, Messages::USER_INSERT_FAILURE);
            }
        } catch (Exception $e) {
            interceptEcho(Messages::USER_INSERT_FAILURE, 500, null, $e->getMessage());
        }
    }

    public function updateUser(string $id, $reqBody)
    {
        if (empty($id) || !is_string($id)) {
            interceptEcho(Messages::INVALID_USER_ID, 400, null, Messages::INVALID_USER_ID);
            return;
        }

        if (empty($reqBody)) {
            interceptEcho(Messages::EMPTY_REQ_BODY, 400, null, Messages::EMPTY_REQ_BODY);
            return;
        }

        $name = isset($reqBody['name']) ? trim($reqBody['name']) : null;
        $email = isset($reqBody['email']) ? trim($reqBody['email']) : null;
        $dob = isset($reqBody['dob']) ? trim($reqBody['dob']) : null;

        if (!empty($name) && !preg_match('/^[a-zA-Z][a-zA-Z0-9 ]*$/', $name)) {
            interceptEcho(Messages::INVALID_USER_NAME, 400, null, Messages::INVALID_USER_NAME);
            return;
        }

        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            interceptEcho(Messages::INVALID_USER_EMAIL, 400, null, Messages::INVALID_USER_EMAIL);
            return;
        }

        if (!empty($dob)) {
            $dob = date('Y-m-d', strtotime($reqBody['dob']));
            $currentDate = date('Y-m-d');
            if (!$dob || $dob > $currentDate) {
                interceptEcho(Messages::INVALID_USER_DOB, 400, null, Messages::INVALID_USER_DOB);
                return;
            }
        }

        if (empty($name) && empty($email) && empty($dob)) {
            interceptEcho(Messages::INCOMPLETE_USER_UPDATE_BODY, 400, null, Messages::INCOMPLETE_USER_UPDATE_BODY);
            return;
        }

        $userData = [
            'name' => $name,
            'email' => $email,
            'dob' => $dob
        ];

        try {
            $success = $this->userModel->updateUser($id, $userData);
            if ($success) {
                interceptEcho(Messages::USER_UPDATE_SUCCESS, 200);
            } else {
                interceptEcho(Messages::USER_UPDATE_FAILURE, 500, null, Messages::USER_UPDATE_FAILURE);
            }
        } catch (Exception $e) {
            interceptEcho(Messages::USER_UPDATE_FAILURE, 500, null, $e->getMessage());
        }
    }

    public function deleteUser(string $id)
    {
        if (empty($id) || !is_string($id)) {
            interceptEcho(Messages::INVALID_USER_ID, 400, null, Messages::INVALID_USER_ID);
            return;
        }

        try {
            $success = $this->userModel->deleteUser($id);
            if ($success) {
                interceptEcho(Messages::USER_DELETE_SUCCESS, 200);
            } else {
                interceptEcho(Messages::USER_NOT_FOUND, 404, null, Messages::USER_NOT_FOUND);
            }
        } catch (Exception $e) {
            interceptEcho(Messages::USER_DELETE_FAILURE, 500, null, $e->getMessage());
        }
    }
}
