<?php
require_once ABS_PATH . '/tools/sql.php';

class Database
{

  private $pdo;

  public function __construct()
  {
    try
    {
      $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR, DB_USER, DB_PASS, PDO_OPTIONS);
      // echo '<p>connected to ' . DB_NAME . '</p>'; // just for debugging
    } catch (\PDOException $e)
    {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
      echo "<p>error: $e!</p>";
    }
  }

  public function run_query($sql, $placeholders = [])
  {
    try
    {
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute($placeholders);
      return $stmt;
    } catch (\PDOException $e)
    {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
      echo "<p>error: $e!</p>";
    }
  }
}
