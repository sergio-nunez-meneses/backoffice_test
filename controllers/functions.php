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
  if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    include(__ROOT__ . '/include/logout_nav.php');
  } else {
    // if ($user['author_status'] === 'admin')
    include(__ROOT__ . '/include/login_nav.php');
    // elseif ($user['author_status'] === 'collaborator') different nqvar
  }
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
    header('Location:/backoffice_test/index.php');
  }
}

function signUp() {
  $username = $password = $status = $error_message = '';
  $error = false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up'])) {

    if (empty($_POST['username'])) {
      $error = true;
      $error_message .= 'username cannot be empty <br>';
    } elseif (strlen($_POST['username']) < 6){
      $error = true;
      $error_message .= 'username must contain more than 6 characters <br>';
      // elseif ($_POST['username'] !== 'sergio') $status = 'collaborator';
    } else {
      $username = $_POST['username'];
    }

    if (empty($_POST['password'])) {
      $error = true;
      $error_message .= 'password cannot be empty <br>';
    } elseif (strlen($_POST['password']) < 7){
      $error = true;
      $error_message .= 'password must contain more than 7 characters <br>';
    } elseif(!preg_match("#[0-9]+#", $_POST['password'])) {
      $error = true;
      $error_message .= 'password must contain at least one number! <br>';
    } elseif(!preg_match("#[a-z]+#", $_POST['password'])) {
      $error = true;
      $error_message .= 'password must contain at least one lowercase character! <br>';
    } elseif(!preg_match("#[A-Z]+#", $_POST['password'])) {
      $error = true;
      $error_message .= 'password must contain at least one uppercase character! <br>';
    } elseif(!preg_match("#\W+#", $_POST['password'])) {
      $error = true;
      $error_message .= 'password must contain at least one symbol! <br>';
    } elseif ($_POST['password'] != $_POST['confirm-password']) {
      $error = true;
      $error_message .= 'passwords do not match <br>';
    } else {
      $options = [
        'cost' => 12,
      ];
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
    }
    $status = $_POST['status'];
  }

  if (!($error)) {
    $pdo = connection();
    $pdo->prepare('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)')->execute([
      'status' => $status,
      'username' => $username,
      'password' => $password,
    ]);

    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $username;

    header('Location:/backoffice_test/index.php');
  } else {
    echo $error_message;
    // header("Location:/backoffice_test/templates/login.php?error=$error_message");
  }
}

function aboutMe() {
  // format time and text
  $pdo = connection();
  $stmt = $pdo->prepare('SELECT * FROM about');
  $stmt->execute();
  $about = $stmt->fetch();

  echo '<section class="about-container">';
  echo '<header>';

  if(isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true && $_SESSION['user'] === 'sergio') {
      echo '<button id="handler-tab">edit</button>';
    }
  }

  echo '<h2 id="aboutTitle" class="about-title">' . $about['about_title'] . '</h2>';
  echo '<img id="aboutImage" class="about-image" src="' . ROOT_DIR . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $about['about_image'] . '">';
  // echo '<div class="">';
  // echo '<p id="date-' . $about_id . '">on ' . $about['DATETIME'] . '</p>';
  // echo '</div>';
  echo '</header>';
  echo '<article id="aboutText" class="about-text">' . $about['about_text'] . '</article>';
  echo '</section>';
}

function articles() {
  $pdo = connection();

  $data = $pdo->query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 10')->fetchAll();

  // declare and format date and text
  // $text = substr($row['article_text'], 0, 50);
  // $date = date('on d/m/Y at H:i', strtotime($row['DATETIME']));

  foreach ($data as $row) {
    echo '<article>';
    echo '<header>';
    echo '<h3><a href="templates/article.php?id=' . $row['article_id'] . '">'. $row['article_title'].'</a></h3>';
    echo '<img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row['article_image'] . '">';
    echo '<div class="">';
    echo '<div>on ' . $row['DATETIME'] . '</div>';
    echo '<div>by '  .$row['author_id'] . '</div>';
    echo '</div>';
    echo '</header>';
    echo '<main>';
    echo '<p>' . $row['article_text'] . '...</p>';
    echo '<a class="" href="templates/article.php?id=' . $row['article_id'] . '">continue reading</a>';
    echo '</main>';
    echo '</article>';
  }
}

function article() {
  $pdo = connection();

  $article_id = $_GET['id'];
  $stmt = $pdo->prepare('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :article_id');
  $stmt->execute([
    'article_id' => $article_id
  ]);
  $article = $stmt->fetch();

  // format date and text
  // $text = wordwrap($article['article_text'], 40);
  // $date = date('on d/m/Y at H:i', strtotime($article['DATETIME']));

  echo '<div>';
  echo '<header>';

  if(isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true && $article['author_username'] === $_SESSION['user']) {
      echo '<button id="handler-tab">edit</button>';
    }
  }

  echo '<h2 id="title-' . $article_id . '" class="">' . $article['article_title'] . '</h2>';
  echo '<img id="image-' . $article_id . '" class="" src="' . dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $article['article_image'] . '">';
  echo '<div class="">';
  echo '<div id="date-' . $article_id . '">on ' . $article['DATETIME'] . '</div>';
  echo '<div>by ' . $article['author_username'] . '</div>';
  echo '</div>';
  echo '</header>';
  echo '<article id="text-' . $article_id . '">' . $article['article_text'] . '</article>';
  echo '</div>';
}

function projects() {
  $pdo = connection();

  $data = $pdo->query('SELECT * FROM projects ORDER BY project_id DESC LIMIT 10')->fetchAll();

  foreach ($data as $row) {
    echo '<article>';
    echo '<header>';
    echo '<h3><a href="project.php?id=' . $row['project_id'] . '&element=project">'. $row['project_title'].'</a></h3>';
    echo '<img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row['project_image'] . '">';
    echo '<div class="">';
    echo '<div>on ' . $row['DATETIME'] . '</div>';
    echo '<div>by '  .$row['author_id'] . '</div>';
    echo '<div>'  .$row['project_technologies'] . '</div>';
    echo '</div>';
    echo '</header>';
    echo '<main>';
    echo '<p>' . $row['project_text'] . '...</p>';
    echo '<a class="" href="project.php?id=' . $row['project_id'] . '&element=project">continue reading</a>';
    echo '</main>';
    echo '</article>';
  }
}

function ajaxReceive() {
  $pdo = connection();
  $form = 'ajax-element-form';
  $section = $element_type = $action = $action_message = $error_message = '';
  $error = false;

  date_default_timezone_set('Europe/Paris');

  if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    $error = true;
    $error_message .= 'sign in to edit this article <br>';
  } else {

    if (empty($_POST['title'])) {
      $error_message .= 'title cannot be empty <br>';
      $error = true;
    } elseif (strlen($_POST['title']) < 5) {
      $error_message .= 'title must contain more than 5 characters <br>';
      $error = true;
    } else {
      $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    }

    if (empty($_POST['text'])) {
      $error_message .= 'text cannot be empty <br>';
      $error = true;
    } elseif (strlen($_POST['text']) < 10){
      $error_message .= 'text must contain more than 10 characters <br>';
      $error = true;
    } else {
      $element_text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
    }

    if (!$error) {
      $element_type = $_POST['content'][0];
      $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
      $element_date = filter_var(substr(date("Y-m-d H:i:sa"), 0, -2), FILTER_SANITIZE_STRING);
      $image_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
      $element_image = filter_var($_FILES['images']['name'][0], FILTER_SANITIZE_STRING);

      move_uploaded_file($_FILES['images']['tmp_name'][0], $image_dir . $element_image);

      $username = $_SESSION['user'];
      $stmt = $pdo->prepare('SELECT author_id FROM authors WHERE author_username = :username');
      $stmt->execute([
        'username' => $username
      ]);
      $author = $stmt->fetch();
      $author_id = filter_var($author['author_id'], FILTER_SANITIZE_STRING);

      if ($_POST['action'][0] === 'create') {
        if ($_POST['content'][0] === 'article') {
          // move image
          $section = $_POST['content'][0];

          $pdo->prepare('INSERT INTO articles VALUES (:element_id, :element_title, :element_text, :element_date, :element_image, :author_id)')->execute([
            'element_id' => $element_id,
            'element_title' => $element_title,
            'element_text' => $element_text,
            'element_date' => $element_date,
            'element_image' => $element_image,
            'author_id' => $author_id
          ]);
        } elseif ($_POST['content'][0] === 'project') {
          // edit project
          // $section = $_POST['content'][0];
        }

        $action = $_POST['action'][0];
        $action_message = 'element created <br>';

      } elseif ($_POST['action'][0] === 'edit') {
        if ($_POST['content'][0] === 'about') {
          // move image
          $section = $_POST['content'][0];

          $pdo->prepare('UPDATE about SET about_title = :element_title, about_image = :element_image, about_text = :element_text WHERE about_id = :element_id')->execute([
            'element_title' => $element_title,
            'element_image' => $element_image,
            'element_text' => $element_text,
            'element_id' => $element_id
          ]);
        } elseif ($_POST['content'][0] === 'article') {
          // move image
          $section = $_POST['content'][0];

          $pdo->prepare('UPDATE articles SET article_title = :element_title, article_text = :element_text, DATETIME = :element_date, article_image = :element_image, author_id = :author_id WHERE article_id = :element_id')->execute([
            'element_title' => $element_title,
            'element_text' => $element_text,
            'element_date' => $element_date,
            'element_image' => $element_image,
            'author_id' => $author_id,
            'element_id' => $element_id
          ]);
        } elseif ($_POST['content'][0] === 'project') {
          // update project
          // $section = $_POST['content'][0];
        }

        $action = $_POST['action'][0];
        $action_message = 'element edited <br>';

      } elseif ($_POST['action'][0] === 'archive') {
        // $section = $_POST['content'][0];
      } elseif ($_POST['action'][0] === 'delete') {
        if ($_POST['content'][0] === 'article') {
          $pdo->prepare('DELETE FROM articles WHERE article_id = :element_id')->execute([
            'element_id' => $element_id
          ]);
        } elseif ($_POST['content'][0] === 'project') {
          $pdo->prepare('DELETE FROM projects WHERE project_id = :element_id')->execute([
            'element_id' => $element_id
          ]);
        }

        $action = $_POST['action'][0];
        $action_message = 'element deleted <br>';

      }
    } else {
      $error_message .= 'could not perform requested action <br>';
    }

    // back to ajax.js
    $array = [
      'form' => $form,
      'action' => $action,
      'action_message' => $action_message,
      'element' => $element_type,
      'id' => $element_id,
      'title' => $element_title,
      'text' => $element_text,
      'date' => $element_date,
      'image' => $element_image,
      'author' => $author_id
    ];
    echo json_encode($array);
    // var_dump($array);

  }
}

function sendMail() {
  // $pdo = connection();

  $form = 'ajax-mail-form';
  $info = $error_message = '';
  $error = false;

  if (empty($_POST['firstname'])) {
    $error_message .= 'firstname cannot be empty <br>';
    $error = true;
  } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['firstname'])) {
    $error_message .= 'invalid firstname format';
    $error = true;
  } else {
    $username = $_POST['firstname'];
  }

  if (empty($_POST['lastname'])) {
    $error_message .= 'lastname cannot be empty <br>';
    $error = true;
  } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['lastname'])) {
    $error_message .= 'invalid lastname format <br>';
    $error = true;
  } else {
    $lastname = $_POST['lastname'];
  }

  if (empty($_POST['email'])) {
    $error_message .= 'email cannot be empty <br>';
    $error = true;
  } elseif (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $_POST['email'])) {
    $error_message .= 'invalid email format <br>';
    $error = true;
  } else {
    $from = $_POST['email'];
  }

  if (!($error)) {
    $to = "To: $from";
    $subject = "message from $username $lastname";
    $message = $_POST['message'];
    $headers = 'From: contact@site.com';

    if (mail($to, $subject, $message, $headers)) {
      $info = 'mail sucessfully sent!';
    } else {
      $info = 'failed to send email!';
    }
  }

  // back to ajax.js
  $array = [
    'form' => $form,
    'info' => $info,
    'error' => $error_message
  ];
  echo json_encode($array);
}

?>
