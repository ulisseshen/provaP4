<?php
class UserRepository {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function findById($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['name'], $row['lastName'], $row['email'], $row['password']);
  }

  public function findByEmail($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['name'], $row['email'], $row['password']);
  }

  public function save(User $user) {
    $stmt = $this->db->prepare("INSERT INTO users (name,lastName, email, password) VALUES (?,, ?, ?, ?)");
    $stmt->execute([$user->getName(), $user->getLastName(), $user->getEmail(), $user->getPassword()]);
    $user->setId($this->db->lastInsertId());
  }
}

?>
