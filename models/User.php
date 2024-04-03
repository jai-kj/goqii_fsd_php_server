<?php
class User
{
  // DB stuff
  private $conn;
  private $table = 'users';

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get all users
  public function getAllUsers()
  {
    $query = 'SELECT id, name, email, dob, created_at, updated_at FROM ' . $this->table . ' ORDER BY updated_at DESC';
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $users;
  }

  // Get single user by ID
  public function getUserById(string $id)
  {
    $query = 'SELECT id, name, email, dob, created_at, updated_at 
      FROM ' . $this->table . ' 
      WHERE id = :id';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  // Insert new user
  public function insertUser(string $name, string $email, string $dob)
  {
    $password = password_hash(bin2hex(random_bytes(8)), PASSWORD_DEFAULT);

    $query = 'INSERT INTO ' . $this->table . ' (name, email, password, dob) 
              VALUES (:name, :email, :password, :dob)';
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':dob', $dob);
    $stmt->execute();
    return $stmt->rowCount() > 0;
  }

  // Update user details by ID
  public function updateUser(string $id, array $userData)
  {
    $setClause = '';
    $params = array(':id' => $id);

    if (isset($userData['name'])) {
      $setClause .= 'name = :name, ';
      $params[':name'] = $userData['name'];
    }

    if (isset($userData['email'])) {
      $setClause .= 'email = :email, ';
      $params[':email'] = $userData['email'];
    }

    if (isset($userData['dob'])) {
      $setClause .= 'dob = :dob, ';
      $params[':dob'] = $userData['dob'];
    }

    // Remove trailing comma and space
    $setClause = rtrim($setClause, ', ');

    $query = 'UPDATE ' . $this->table . ' SET ' . $setClause . ' WHERE id = :id';
    $stmt = $this->conn->prepare($query);

    foreach (['id', 'name', 'email', 'dob'] as $paramName) {
      if (isset($params[":$paramName"])) {
        $stmt->bindParam(":$paramName", $params[":$paramName"]);
      }
    }

    $stmt->execute();
    return $stmt->rowCount() > 0;
  }
}
