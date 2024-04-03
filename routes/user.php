<?php

require_once __DIR__ . '/../controller/user.php';

$userController = new UserController($conn);

switch ($_SERVER['REQUEST_METHOD']) {
    case Constants::API_METHODS['GET']:
        if ($_SERVER['REQUEST_URI'] === Constants::API_ROUTES['USER_LIST']) {
            $userController->getAllUsers();
        } else {
            $userController->getUserById($_GET['id']);
        }
        break;

    case Constants::API_METHODS['POST']:
        break;

    case Constants::API_METHODS['PUT']:
        break;

    case Constants::API_METHODS['DELETE']:
        break;

    default:
        interceptEcho(Messages::INVALID_METHOD, 405, null, Messages::INVALID_METHOD);
        break;
}
