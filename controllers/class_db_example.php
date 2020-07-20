<?php
class Database
{
  // property declaration
  private $database = '';
  private $host = '';
  private $charset = '';
  private $user = '';
  private $password = '';
  private $options = [];
  // method declaration
  public function __construct() {
    try {
      $this->$pdo = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->database . ';charset=' . $this->charset, $this->user, $this->password, $this->options);
      // echo 'connected to OOP test!';
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
      echo "error: $e!";
    }
  }
  // method declaration
  public function run_query($sql, $placeholders = []) {
    try {
      $stmt = $this->$pdo->prepare($sql);
      $stmt->execute($placeholders);
      return $stmt;
    } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
      echo "error: $e!";
    }
  }
}
?>
