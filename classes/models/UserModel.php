<?php

class UserModel extends Database
{

  public function get_user($username)
  {
    $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
    $user = $stmt->fetch();
    return $user;
  }

  public function get_users()
  {
    $stmt = $this->run_query('SELECT * FROM authors');
    $user = $stmt->fetchAll();
    return $user;
  }

  public function get_user_id($username)
  {
    $stmt = $this->run_query('SELECT author_id FROM authors WHERE author_username = :username', ['username' => $username]);
    $user_id = $stmt->fetch();
    return $user_id['author_id'];
  }

  public function get_username($id)
  {
    $stmt = $this->run_query('SELECT author_username FROM authors WHERE author_id = :id', ['id' => $id]);
    $username = $stmt->fetch();
    return $username['author_username'];
  }

  public function create_new_user($status, $username, $password)
  {
    $stmt = $this->run_query('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)', ['status' => $status, 'username' => $username, 'password' => $password]);
    $result = $stmt->fetch();
    return $result['LAST_INSERT_ID()'];
  }
}
