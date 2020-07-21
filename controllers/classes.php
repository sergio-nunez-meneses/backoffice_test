<?php

require_once dirname(dirname(__FILE__)) . '/controllers/class_db.php';

class User extends Database
{
  public function sign_up() {
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
      $this->run_query('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)', ['status' => $status, 'username' => $username, 'password' => $password]);

      $_SESSION['logged_in'] = true;
      $_SESSION['user'] = $username;
      $_SESSION['status'] = $status;

      header('Location:../index.php');
    } else {
      header("Location:../templates/login.php?error=yes&error_message=$error_message");
    }
  }
  public function login() {
    $error_message = '';
    $error = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-in'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
      $user = $stmt->fetch();

      if ($user == false) {
        $error = true;
        $error_message .= 'user does not exist <br>';
      } else {
        $username = $user['author_username'];
        $stored_password = $user['author_password'];
        $status = $user['author_status'];

        if (password_verify($password, $stored_password) && $error !== true) {
          $_SESSION['logged_in'] = true;
          $_SESSION['user'] = $username;
          $_SESSION['status'] = $status;
          header('Location:../index.php');
        } else {
          $error_message .= 'password incorrect <br>';
          header("Location:../templates/login.php?error=yes&error_message=$error_message");
        }
      }
    }
  }
  public function logout() {
    if ($_GET['logout'] == 'yes') {
      session_unset();
      session_destroy();
      header('Location:../index.php');
    }
  }
  function is_logged() {
    if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
      include __ROOT__ . '/include/logout_nav.php';
    } else {
      if ($_SESSION['status'] === 'admin') {
        include __ROOT__ . '/include/admin_login_nav.php';
      } elseif ($_SESSION['status'] === 'collaborator') {
        include __ROOT__ . '/include/collaborator_login_nav.php';
      }
    }
  }
}

class Element extends Database
{
  public function display_content($element) {
    if ($element !== 'about') {
      if ($element === 'articles') {
        $data = $this->run_query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 10');

        $id = 'article_id';
        $title = 'article_title';
        $text = 'article_text';
        $date = 'DATETIME';
        $image = 'article_image';
        $author = 'author_id';
      } elseif ($element === 'projects') {
        $data = $this->run_query('SELECT * FROM projects ORDER BY project_id DESC LIMIT 10');

        $id = 'project_id';
        $title = 'project_title';
        $text = 'project_text';
        $date = 'DATETIME';
        $image = 'project_image';
        $author = 'author_id';
      }
      foreach ($data as $row) {
        echo
        '<article>
        <header>
        <h3><a href="templates/element.php?id=' . $row[$id] . '&element=' . $element .'">' . $row[$title].'</a></h3>
        <img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row[$image] . '">
        <div class="">
        <div>on ' . $row[$date] . '</div>
        <div>by '  .$row[$author] . '</div>
        </div>
        </header>
        <main>
        <p>' . $row[$text] . '...</p>
        <a class="" href="templates/element.php?id=' . $row[$id] . '&element=' . $element . '">continue reading</a>
        </main>
        </article>';
      }
    } else {
      $about = $this->run_query('SELECT * FROM about')->fetch();

      echo
      '<section class="about-container">
      <header>';

      if ($_SESSION['logged_in'] == true && $_SESSION['status'] === 'admin') {
        echo '<button id="handler-tab">edit</button>';
      }

      echo
      '<h2 id="aboutTitle" class="about-title">' . $about['about_title'] . '</h2>
      <img id="aboutImage" class="about-image" src="../img' . DIRECTORY_SEPARATOR . $about['about_image'] . '">
      </header>
      <article id="aboutText" class="about-text">' . $about['about_text'] . '</article>
      </section>
      <button id="cvTab">show cv</button>
      <div id="myModal" class="modal hidden">
      <button id="closeBtn" class="close cursor">&times;</button>
      <div class="cv-container">
      <iframe src="..' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'cv.pdf"></iframe>
      </div>
      </div>';
    }
  }

  public function display_element() {
    $element = $_GET['element'];
    $element_id = $_GET['id'];

    if ($element === 'articles') {
      $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :element_id', ['element_id' => $element_id]);

      $title = 'article_title';
      $text = 'article_text';
      $date = 'DATETIME';
      $image = 'article_image';
      $author = 'author_id';
    } elseif ($element === 'projects') {
      $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE project_id = :element_id', ['element_id' => $element_id]);

      $title = 'project_title';
      $text = 'project_text';
      $date = 'DATETIME';
      $image = 'project_image';
      $author = 'author_id';
    } else {
      return;
    }

    $element = $stmt->fetch();

    echo
    '<div id="element-' . $element_id . '">
    <header>';

    if(isset($_SESSION['logged_in'])) {
      if ($_SESSION['logged_in'] == true && $element['author_username'] === $_SESSION['user']) {
        echo '<button id="handler-tab">edit</button>';
      }
    }

    echo
    '<h2 id="title-' . $element_id . '" class="">' . $element[$title] . '</h2>
    <img id="image-' . $element_id . '" class="" src="../img' . DIRECTORY_SEPARATOR . $element[$image] . '">
    <div class="">
    <div id="date-' . $element_id . '">on ' . $element[$date] . '</div>
    <div>by ' . $element['author_username'] . '</div>
    </div>
    </header>
    <article id="text-' . $element_id . '">' . $element[$text] . '</article>
    </div>';
  }
}

class Editor extends Database
{
  public function content_handler() {
    $element = '';
    $element_type = $_GET['element'];
    $element_id = $_GET['id'];

    if (basename($_SERVER['SCRIPT_FILENAME']) !== 'create_element.php') {
      if ($element_type !== 'about') {
        if ($element_type === 'articles') {
          $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :element_id', ['element_id' => $element_id]);

          $title = 'article_title';
          $text = 'article_text';
          $image = 'article_image';
          $author_id = 'author_id';
        } elseif ($element_type === 'projects') {
          $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE project_id = :element_id', ['element_id' => $element_id]);

          $title = 'project_title';
          $text = 'project_text';
          $image = 'project_image';
          $author_id = 'author_id';
        }
        $element = $stmt->fetch();
      } else {
        $stmt = $this->run_query('SELECT * FROM about WHERE about_id = :element_id', ['element_id' => $element_id]);
        $element = $stmt->fetch();

        $title = 'about_title';
        $text = 'about_text';
        $image = 'about_image';
        $author_id = '1';
      }

      $username = $_SESSION['user'];
      $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
      $author = $stmt->fetch();

      echo
      '<form id="ajax-form" class="hidden" action="../controllers/content_editor_receiver.php" method="post" enctype="multipart/form-data"
      onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
      <legend>element handler</legend>
      <select class="" name="content[]">
      <option value="' . $element_type . '">' . $element_type . '</option>
      </select>
      <input class="" type="number" name="id" value="' . $element_id . '" placeholder="id: ' . $element_id . '">
      <input class="" type="text" name="title" value="' . $element[$title] . '" placeholder="title: ' . $element[$title] . '">
      <input class="" type="number" name="author" value="' . $author['author_id'] . '" placeholder="author: ' . $author['author_username'] . '">
      <input class="" type="file" multiple name="images[]" value="' . $element[$image] . '">
      <textarea class="" name="text" cols="50" rows="8" placeholder="">' . $element[$text] . '</textarea>
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
    } else {
      // query to get articles and projects' last ids

      $username = $_SESSION['user'];
      $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
      $author = $stmt->fetch();

      echo
      '<form id="ajax-form" class="" action="../controllers/content_editor_receiver.php" method="post" enctype="multipart/form-data"
      onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
      <legend>create element</legend>
      <select class="" name="content[]">
      <option value=""></option>
      <option value="articles">article</option>
      <option value="projects">project</option>
      </select>
      <input class="" type="number" name="id" value="" placeholder="element id:">
      <input class="" type="text" name="title" value="" placeholder="element title:">
      <input class="" type="number" name="author" value="' . $author['author_id'] . '" placeholder="author:">
      <input class="" type="file" multiple name="images[]" value="">
      <textarea class="" name="text" cols="50" rows="8" placeholder="element text"></textarea>
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
  }
}

?>
