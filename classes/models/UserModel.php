<?php

class UserModel extends Database
{
  private $username;
  private $password;
  private $status;

  public function get_user($username)
  {
    $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
    $user = $stmt->fetch();
    return $user;
  }

  public function create_new_user($status, $username, $password)
  {
    $this->run_query('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)', ['status' => $status, 'username' => $username, 'password' => $password]);
  }
}
