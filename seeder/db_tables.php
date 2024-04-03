<?php

// Include the dotenv library
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Function to connect to the database
function connectToDatabase($host, $dbname, $username, $password)
{
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Function to create the user table
function createUserTable($pdo)
{
    try {
        $pdo->exec("CREATE TABLE IF NOT EXISTS users (
            id CHAR(36) PRIMARY KEY DEFAULT (UUID()),
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            dob DATE NOT NULL,
            reset_password_token VARCHAR(255),
            reset_password_expire DATE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        echo "User table created successfully\n";
    } catch (PDOException $e) {
        die("Error creating user table: " . $e->getMessage());
    }
}

// Function to load data into the user table
function loadDataIntoUserTable($pdo)
{
    // Read seed data from seed.json
    $seedData = file_get_contents(__DIR__ . '/seed.json');

    // Decode JSON data
    $seedArray = json_decode($seedData, true);

    // Prepare and execute SQL insert statements
    foreach ($seedArray['users'] as $user) {
        $name = $user['name'];
        $email = $user['email'];
        $password = password_hash($user['password'], PASSWORD_DEFAULT);
        $dob = date('Y-m-d', strtotime($user['dob']));

        // Insert user into users table
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, dob) VALUES (:name, :email, :password, :dob)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':dob', $dob);

        try {
            $stmt->execute();
            echo "User '$name' inserted successfully\n";
        } catch (PDOException $e) {
            echo "Error inserting user '$name': " . $e->getMessage() . "\n";
        }
    }
}

// Database configuration
$host = $_ENV['DB_HOST'];
$dbname = $_ENV['DB_DATABASE'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];

// Connect to the database
$pdo = connectToDatabase($host, $dbname, $username, $password);

// Check command-line arguments
if ($argc != 2) {
    die("Usage: php index.php <option>\nOptions: create-tables | load-data\n");
}

// Determine the option
$option = $argv[1];

// Perform the chosen option
switch ($option) {
    case 'create-tables':
        createUserTable($pdo);
        break;
    case 'load-data':
        loadDataIntoUserTable($pdo);
        break;
    default:
        die("Invalid option. Usage: php index.php <option>\nOptions: create-tables | load-data\n");
}
