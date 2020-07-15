<?php

function connection() {
  // require __ROOT__ . '/controllers/database.php';
  require 'C:\wamp64\www\snunezmeneses\backoffice_test\controllers\database.php';

  $host = 'localhost';
  $charset = 'utf8';
  $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

  try {
    $pdo = new PDO($dsn, $user, $password, $options);
  } catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
  }
  return $pdo;
}

function isLogged() {
  if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) include(__ROOT__ . '/include/logout_nav.php');
  else include(__ROOT__ . '/include/login_nav.php');
}

function login() {
  $pdo = connection();

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-in'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM authors WHERE author_username = :username');
    $stmt->execute([
      'username' => $username
    ]);
    $user = $stmt->fetch();

    if ($user == false) {
      echo 'user does not exist';
    } else {
      $stored_password = $user['author_password'];
      $username = $user['author_username'];

      if (password_verify($password, $stored_password)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $username;
        header('Location:/backoffice_test/index.php');
        // if ($user['author_status'] == admin) header('Location:admin.php');
        // else header('Location:collaborator.php');
      } else {
        echo 'password incorrect';
      }
    }
  }
}

function logout() {
  if ($_GET['logout'] == 'yes') {
    session_unset();
    session_destroy();
    header('Location:.');
  }
}

function signUp() {
  $username = $password = $status = $error_message = '';
  $error = false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up'])) {

    if (empty($_POST['username'])) {
      $error_message .= 'username cannot be empty';
      $error = true;
    } elseif (strlen($_POST['username']) < 6){
      $error_message .= 'username must contain more than 6 characters';
      $error = true;
      // elseif ($_POST['username'] !== 'sergio') $status = 'collaborator';
    } else {
      $username = $_POST['username'];
    }

    if (empty($_POST['password'])) {
      $error_message .= 'password cannot be empty';
      $error = true;
    } elseif (strlen($_POST['password']) < 7){
      $error_message .= 'password must contain more than 7 characters';
      $error = true;
    } elseif ($_POST['password'] != $_POST['confirm-password']) {
      $error_message .= 'passwords do not match';
      $error = true;
      // elseif (!(preg_match('/[\'^£$%&*()}{@#~<>,|=_+¬-]/', $_POST['password'])) echo 'password must contain at least 1 special character';
    } else {
      $options = [
        'cost' => 12,
      ];
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    }
    $status = $_POST['status'];
  }

  $pdo = connection();

  if (!($error)) {
    $pdo->prepare('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)')->execute([
      'status' => $status,
      'username' => $username,
      'password' => $password,
    ]);

    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $username;

    header('Location:/backoffice_test/index.php');
    // if ($status == admin) header('Location:admin.php');
    // else header('Location:collaborator.php');
  } else {
    echo $error_message;
    // header("Location:/backoffice_test/templates/login.php?error=$error_message");
  }
}

function articles() {
  $pdo = connection();

  $data = $pdo->query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 10')->fetchAll();

  foreach ($data as $row) {
    echo '<article>';
    echo '<header>';
    echo '<h3><a href="article.php?id=' . $row['article_id'] . '">'. $row['article_title'].'</a></h3>';
    echo '<img class="" src="' . $row['article_image'] . '">';
    echo '<div class="">';
    echo '<div>on ' . $row['DATETIME'] . '</div>';
    echo '<div>by '  .$row['author_id'] . '</div>';
    echo '</div>';
    echo '</header>';
    echo '<main>';
    echo '<p>' . $row['article_text'] . '...</p>';
    echo '<a class="" href="article.php?id=' . $row['article_id'] . '">continue reading</a>';
    echo '</main>';
    echo '</article>';
  }
}

function article() {
  $article_id = $_GET['id'];

  $pdo = connection();
  $stmt = $pdo->prepare('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :article_id');
  $stmt->execute([
    'article_id' => $article_id
  ]);
  $article = $stmt->fetch();

  echo '<section>';
  echo '<header>';

  if(isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true && $article['author_username'] === $_SESSION['user']) {
      echo '<button id="handler-tab">edit</button>';
    }
  }

  echo '<h2 class="">' . $article['article_title'] . '</h2>';
  echo '<img class="" src="' . $article['article_image'] . '">';
  echo '<div class="">';
  echo '<div>on ' . $article['DATETIME'] . '</div>';
  echo '<div>by ' . $article['author_username'] . '</div>';
  echo '</div>';
  echo '</header>';
  echo '<article>' . $article['article_text'] . '</article>';
  echo '</section>';
}

function ajaxReceive() {
  $pdo = connection();
  date_default_timezone_set('Europe/Paris');

  // echo 'check received data';
  // print_r($_POST);
  // echo 'check uploaded files';
  // print_r($_FILES);

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) { // prevent editing
    echo 'sign in to edit this article';
  } else {
    $article_id = $_POST['id'];

    $error_message = '';
    $error = false;

    if ($_POST['action'][0] == 'edit') {
      if (empty($_POST['title'])) {
        $error_message .= 'title cannot be empty';
        $error = true;
      } elseif (strlen($_POST['title']) < 5) {
        $error_message .= 'title must contain more than 5 characters';
        $error = true;
      } else {
        $article_title = $_POST['title'];
      }

      if (empty($_POST['text'])) {
        $error_message .= 'text cannot be empty';
        $error = true;
      } elseif (strlen($_POST['text']) < 10){
        $error_message .= 'text must contain more than 10 characters';
        $error = true;
      } else {
        $article_text = $_POST['text'];
      }

      if (!($error)) {
        $author_id = $_POST['author'];
        $article_date = substr(date("Y-m-d H:i:sa"), 0, -2);
        $article_image = $_FILES['images']['tmp_name'][0];

        $pdo->prepare('UPDATE articles SET article_title = :article_title, article_text = :article_text, DATETIME = :article_date, article_image = :article_image, author_id = :author_id WHERE article_id = :article_id')->execute([
          'article_title' => $article_title,
          'article_text' => $article_text,
          'article_date' => $article_date,
          'article_image' => $article_image,
          'author_id' => $author_id,
          'article_id' => $article_id
        ]);
        // echo 'project edited';
      }
    } elseif ($_POST['action'][0] == 'archive') {
      // echo 'project archived';
    } elseif ($_POST['action'][0] == 'delete') {
      // $pdo->prepare('DELETE FROM articles WHERE article_id = :article_id')->execute(['article_id' => $article_id]);
      // echo 'project deleted';
    } else {
      echo 'could not perform requested action';
    }

    // back to ajax.js
    $array = [
      'id' => $article_id,
      'title' => $article_title,
      'text' => $article_text,
      'date' => $article_date,
      'image' => $article_image,
      'author' => $author_id
    ];
    echo json_encode($array);
  }
}

?>
