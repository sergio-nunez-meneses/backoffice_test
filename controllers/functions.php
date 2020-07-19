<?php

// declare constant for script's absolute path

function connection() {
  require dirname(dirname(__FILE__))  . '/controllers/database.php';

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

function is_logged() {
  // $pdo = connection();

  if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    include(__ROOT__ . '/include/logout_nav.php');
  } else {
    if ($_SESSION['status'] === 'admin') {
      include(__ROOT__ . '/include/admin_login_nav.php');
    } elseif ($_SESSION['status'] === 'collaborator') {
      include(__ROOT__ . '/include/collaborator_login_nav.php');
    }
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
      $username = $user['author_username'];
      $stored_password = $user['author_password'];
      $status = $user['author_status'];

      if (password_verify($password, $stored_password)) {
        $_SESSION['logged_in'] = true;
        $_SESSION['user'] = $username;
        $_SESSION['status'] = $status;
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

function sign_up() {
  $username = $password = $status = $error_message = '';
  $error = false;

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up'])) {

    if (empty($_POST['username'])) {
      $error = true;
      $error_message .= 'username cannot be empty <br>';
    } elseif (strlen($_POST['username']) < 6){
      $error = true;
      $error_message .= 'username must contain more than 6 characters <br>';
    } else {
      $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
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
  }

  $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

  if (!($error)) {

    $pdo->prepare('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)')->execute([
      'status' => $status,
      'username' => $username,
      'password' => $password,
    ]);

    $_SESSION['logged_in'] = true;
    $_SESSION['user'] = $username;
    $_SESSION['status'] = $status;

    header('Location:/backoffice_test/index.php');
  } else {
    header("Location:/backoffice_test/templates/login.php?error=yes&error_message=$error_message");
  }
}

function content_handler() {
  $element_id = $_GET['id'];
  $element_type = $_GET['element'];

  $pdo = connection();

  if ($element_type === 'about') {
    $stmt = $pdo->prepare('SELECT * FROM about WHERE about_id = :element_id');
    $stmt->execute([
      'element_id' => $element_id
    ]);
    $element = $stmt->fetch();

    $element_title = $element['about_title'];
    $element_text = $element['about_text'];
    $element_image = $element['about_image'];
    $element_author = '1';
  } elseif ($element_type === 'article') {
    $stmt = $pdo->prepare('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :element_id');
    $stmt->execute([
      'element_id' => $element_id
    ]);
    $element = $stmt->fetch();

    $element_title = $element['article_title'];
    $element_text = $element['article_text'];
    $element_image = $element['article_image'];
    $element_author = $element['author_id'];
  } elseif ($element_type === 'project') {
    $stmt = $pdo->prepare('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE projects.project_id = :element_id');
    $stmt->execute([
      'element_id' => $element_id
    ]);
    $element = $stmt->fetch();

    $element_title = $element['article_title'];
    $element_text = $element['article_text'];
    $element_image = $element['article_image'];
    $element_author = $element['author_id'];
  }

  $username = $_SESSION['user'];
  $stmt = $pdo->prepare('SELECT * FROM authors WHERE author_username = :username');
  $stmt->execute([
    'username' => $username
  ]);
  $author = $stmt->fetch();

  echo
  '<form id="ajax-form" class="hidden" action="../controllers/ajaxReceive.php" method="post" enctype="multipart/form-data"
  onsubmit="ajaxSend(this); return false;">
  <fieldset class="ajax-form-container">
  <legend>element handler</legend>
  <select class="" name="content[]">
  <option value="' . $element_type . '">' . $element_type . '</option>
  </select>
  <input class="" type="number" name="id" value="' . $element_id . '" placeholder="id: ' . $element_id . '">
  <input class="" type="text" name="title" value="' . $element_title . '" placeholder="title: ' . $element_title . '">
  <input class="" type="number" name="author" value="' . $element_author . '" placeholder="author: ' . $author['author_username'] . '">
  <input class="" type="file" multiple name="images[]" value="' . $element_image . '">
  <textarea class="" name="text" cols="50" rows="8" placeholder="">' . $element_text . '</textarea>
  <legend>choose action</legend>
  <select class="" name="action[]">
  <option></option>
  <option>create</option>
  <option>edit</option>
  <option>archive</option>
  <option>delete</option>
  </select>
  <input id="" class="" type="submit" name="submit" value="submit"/>
  </fieldset>
  </form>';
}

function display_about() {
  // format time and text
  $pdo = connection();
  $stmt = $pdo->prepare('SELECT * FROM about');
  $stmt->execute();
  $about = $stmt->fetch();

  echo
  '<section class="about-container">
  <header>';

  if ($_SESSION['logged_in'] == true && $_SESSION['status'] === 'admin') {
    echo '<button id="handler-tab">edit</button>';
  }

  echo
  '<h2 id="aboutTitle" class="about-title">' . $about['about_title'] . '</h2>
  <img id="aboutImage" class="about-image" src="' . ROOT_DIR . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $about['about_image'] . '">
  </header>
  <article id="aboutText" class="about-text">' . $about['about_text'] . '</article>
  </section>';
  // echo '<div class="">';
  // echo '<p id="date-' . $about_id . '">on ' . $about['DATETIME'] . '</p>';
  // echo '</div>';
}

function display_articles() {
  $pdo = connection();

  $data = $pdo->query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 10')->fetchAll();

  // declare and format date and text
  // $text = substr($row['article_text'], 0, 50);
  // $date = date('on d/m/Y at H:i', strtotime($row['DATETIME']));

  foreach ($data as $row) {
    echo
    '<article>
    <header>
    <h3><a href="templates/article.php?id=' . $row['article_id'] . '&element=article">'. $row['article_title'].'</a></h3>
    <img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row['article_image'] . '">
    <div class="">
    <div>on ' . $row['DATETIME'] . '</div>
    <div>by '  .$row['author_id'] . '</div>
    </div>
    </header>
    <main>
    <p>' . $row['article_text'] . '...</p>
    <a class="" href="templates/article.php?id=' . $row['article_id'] . '&element=article">continue reading</a>
    </main>
    </article>';
  }
}

function display_article() {
  $article_id = $_GET['id'];

  $pdo = connection();
  $stmt = $pdo->prepare('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :article_id');
  $stmt->execute([
    'article_id' => $article_id
  ]);
  $article = $stmt->fetch();

  // format date and text
  // $text = wordwrap($article['article_text'], 40);
  // $date = date('on d/m/Y at H:i', strtotime($article['DATETIME']));

  echo
  '<div>
  <header>';

  if(isset($_SESSION['logged_in'])) {
    if ($_SESSION['logged_in'] == true && $article['author_username'] === $_SESSION['user']) {
      echo '<button id="handler-tab">edit</button>';
    }
  }

  echo
  '<h2 id="title-' . $article_id . '" class="">' . $article['article_title'] . '</h2>
  <img id="image-' . $article_id . '" class="" src="' . dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $article['article_image'] . '">
  <div class="">
  <div id="date-' . $article_id . '">on ' . $article['DATETIME'] . '</div>
  <div>by ' . $article['author_username'] . '</div>
  </div>
  </header>
  <article id="text-' . $article_id . '">' . $article['article_text'] . '</article>
  </div>';
}

function display_projects() {
  $pdo = connection();

  $data = $pdo->query('SELECT * FROM projects ORDER BY project_id DESC LIMIT 10')->fetchAll();

  foreach ($data as $row) {
    echo
    '<article>
    <header>
    <h3><a href="project.php?id=' . $row['project_id'] . '&element=project">'. $row['project_title'].'</a></h3>
    <img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row['project_image'] . '">
    <div class="">
    <div>on ' . $row['DATETIME'] . '</div>
    <div>by '  .$row['author_id'] . '</div>
    <div>'  .$row['project_technologies'] . '</div>
    </div>
    </header>
    <main>
    <p>' . $row['project_text'] . '...</p>
    <a class="" href="project.php?id=' . $row['project_id'] . '&element=project">continue reading</a>
    </main>
    </article>';
  }
}

function ajax_receiver() {
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
      $author_id = $author['author_id'];

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

function send_mail() {
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
