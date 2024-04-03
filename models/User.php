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
}
