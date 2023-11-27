<?php
class UserRepository {
  private PDO $pdo;

  public function __construct(Database $db) {
    $this->pdo = $db->getPdo();
    //create table if not exists
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      name VARCHAR(30) NOT NULL,
      lastName VARCHAR(30) NOT NULL,
      email VARCHAR(50) NOT NULL,
      password VARCHAR(50) NOT NULL
    )");
  }

  public function findById($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['name'], $row['lastName'], $row['email'], $row['password']);
  }

  public function findByEmail($email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
      return null;
    }
    return new User($row['id'], $row['name'], $row['email'], $row['password']);
  }

  public function saveNew(User $user) {
    $alreadyExists = $this->findByEmail($user->getEmail());
    if ($alreadyExists) {
      return new SaveResult(false, "Email já cadastrado", 409);
    }

    $stmt = $this->pdo->prepare("INSERT INTO users (name,lastName, email, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$user->getName(), $user->getLastName(), $user->getEmail(), $user->getPassword()]);
    $user->setId($this->pdo->lastInsertId());
  }


}

class SaveResult {
  private bool $success;
  private string $message;
  private int $status;

  public function __construct(bool $success, string $message, int $status) {
    $this->success = $success;
    $this->message = $message;
    $this->status = $status;
  }

  public function isSuccess() {
    return $this->success;
  }

  public function getMessage() {
    return $this->message;
  }

  public function getStatus() {
    return $this->status;
  }

  public function getJson() {
    return json_encode([
      "success" => $this->success,
      "message" => $this->message,
      "status" => $this->status
    ]);
  }

}
?>
