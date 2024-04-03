<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../config/Messages.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();


// Create a new database connection
$dbConfig = [
    'host' => $_ENV['DB_HOST'],
    'database' => $_ENV['DB_DATABASE'],
    'username' => $_ENV['DB_USERNAME'],
    'password' => $_ENV['DB_PASSWORD']
];

$database = new Database($dbConfig['host'], $dbConfig['database'], $dbConfig['username'], $dbConfig['password']);
$database->connect();

// Parse the request
$request = $_SERVER['REQUEST_URI'];

// Route the request
switch ($request) {
    case '/':
        echo Messages::SERVER_STATUS_SUCCESS;
        break;
    // Add more cases for other routes if needed
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Route not found"));
        break;
}