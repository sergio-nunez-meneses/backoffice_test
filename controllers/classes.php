<?php

// require_once dirname(dirname(__FILE__)) . '/classes/abstract/db.php';

// class User extends Database
// {
//   public function sign_up() {
//     $username = $password = $status = $error_message = '';
//     $error = false;
//
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up'])) {
//
//       if (empty($_POST['username'])) {
//         $error = true;
//         $error_message .= 'username cannot be empty <br>';
//       } elseif (strlen($_POST['username']) < 6){
//         $error = true;
//         $error_message .= 'username must contain more than 6 characters <br>';
//       } else {
//         $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
//       }
//
//       if (empty($_POST['password'])) {
//         $error = true;
//         $error_message .= 'password cannot be empty <br>';
//       } elseif (strlen($_POST['password']) < 7){
//         $error = true;
//         $error_message .= 'password must contain more than 7 characters <br>';
//       } elseif(!preg_match("#[0-9]+#", $_POST['password'])) {
//         $error = true;
//         $error_message .= 'password must contain at least one number! <br>';
//       } elseif(!preg_match("#[a-z]+#", $_POST['password'])) {
//         $error = true;
//         $error_message .= 'password must contain at least one lowercase character! <br>';
//       } elseif(!preg_match("#[A-Z]+#", $_POST['password'])) {
//         $error = true;
//         $error_message .= 'password must contain at least one uppercase character! <br>';
//       } elseif(!preg_match("#\W+#", $_POST['password'])) {
//         $error = true;
//         $error_message .= 'password must contain at least one symbol! <br>';
//       } elseif ($_POST['password'] != $_POST['confirm-password']) {
//         $error = true;
//         $error_message .= 'passwords do not match <br>';
//       } else {
//         $options = [
//           'cost' => 12,
//         ];
//         $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
//       }
//     }
//
//     $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
//
//     if (!($error)) {
//       // UserModel -> create_new_user()
//       $this->run_query('INSERT INTO authors (author_status, author_username, author_password) VALUES (:status, :username, :password)', ['status' => $status, 'username' => $username, 'password' => $password]);
//
//       $_SESSION['logged_in'] = true;
//       $_SESSION['user'] = $username;
//       $_SESSION['status'] = $status;
//
//       header('Location:../index.php');
//     } else {
//       header("Location:../templates/login.php?error=yes&error_message=$error_message");
//     }
//   }
//   public function login() {
//     $error_message = '';
//     $error = false;
//
//     if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-in'])) {
//       $username = $_POST['username'];
//       $password = $_POST['password'];
//       // UserModel -> get_user()
//       $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
//       $user = $stmt->fetch();
//
//       if ($user == false) {
//         $error = true;
//         $error_message .= 'user does not exist <br>';
//       } else {
//         $username = $user['author_username'];
//         $stored_password = $user['author_password'];
//         $status = $user['author_status'];
//
//         if (password_verify($password, $stored_password) && $error !== true) {
//           $_SESSION['logged_in'] = true;
//           $_SESSION['user'] = $username;
//           $_SESSION['status'] = $status;
//
//
//           header('Location:../index.php');
//         } else {
//           $error_message .= 'password incorrect <br>';
//           header("Location:../templates/login.php?error=yes&error_message=$error_message");
//         }
//       }
//     }
//   }
//   public function logout() {
//     if ($_GET['logout'] == 'yes') {
//       session_unset();
//       session_destroy();
//       header('Location:../index.php');
//     }
//   }
//   function is_logged() {
//     if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//       include __ROOT__ . '/include/logout_nav.php';
//     } else {
//       if ($_SESSION['status'] === 'admin') {
//         include __ROOT__ . '/include/admin_login_nav.php';
//       } elseif ($_SESSION['status'] === 'collaborator') {
//         include __ROOT__ . '/include/collaborator_login_nav.php';
//       }
//     }
//   }
// }

// class Element extends Database
// {
//   public function display_content($element) {
//
//     if ($element !== 'about') {
//       if ($element === 'articles') {
//         $data = $this->run_query('SELECT * FROM articles WHERE article_archived = 0 ORDER BY article_id DESC LIMIT 10');
//
//         $id = 'article_id';
//         $title = 'article_title';
//         $text = 'article_text';
//         $date = 'DATETIME';
//         $image = 'article_image';
//         $author = 'author_id';
//       } elseif ($element === 'all-articles') {
//         $data = $this->run_query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 6');
//
//         $element = 'articles';
//         $id = 'article_id';
//         $title = 'article_title';
//         $text = 'article_text';
//         $date = 'DATETIME';
//         $image = 'article_image';
//         $author = 'author_id';
//       } else
//       if ($element === 'projects') {
//         $data = $this->run_query('SELECT * FROM projects WHERE project_archived = 0 ORDER BY project_id DESC LIMIT 10');
//
//         $id = 'project_id';
//         $title = 'project_title';
//         $text = 'project_text';
//         $date = 'DATETIME';
//         $image = 'project_image';
//         $author = 'author_id';
//       } elseif ($element === 'all-projects') {
//         $data = $this->run_query('SELECT * FROM projects ORDER BY project_id DESC LIMIT 6');
//
//         $element = 'projects';
//         $id = 'article_id';
//         $title = 'article_title';
//         $text = 'article_text';
//         $date = 'DATETIME';
//         $image = 'article_image';
//         $author = 'author_id';
//       }
//
//       foreach ($data as $row) {
//         $formatted_date = $row[$date];
//         $formatted_date = date('jS F, Y H:i', strtotime($formatted_date));
//
//         $shorten_text = $row[$text];
//         $shorten_text = substr($row[$text], 0, 80);
//
//         echo
//         '<section class="element-box">
//         <img class="element-image" src="' . 'public/img/' . $row[$image] . '">
//         <div class="transparent-box">
//         <article class="element-caption">
//         <header>
//         <h3><a class="element-title" href="templates/element.php?id=' . $row[$id] . '&element=' . $element .'">' . $row[$title].'</a></h3>
//         <div class="">
//         <div class="element-date">on ' . $formatted_date . '</div>
//         <div class="element-author">by '  .$row[$author] . '</div>
//         </div>
//         </header>
//         <main>
//         <p>' . $shorten_text . '...</p>
//         <a class="opacity-low" href="templates/element.php?id=' . $row[$id] . '&element=' . $element . '">continue reading</a>
//         </main>
//         </article>
//         </div>
//         </section>';
//       }
//     } else {
//       $about = $this->run_query('SELECT * FROM about')->fetch();
//       $paragraphs = explode("\n", $about['about_text']);
//       $formatted_text = '';
//
//       foreach ($paragraphs as $paragraph) {
//         $formatted_text .= '<p>' . $paragraph . '</p>';
//       }
//
//       if ($_SESSION['logged_in'] == true && $_SESSION['status'] === 'admin') {
//         echo '<button id="handler-tab">edit</button>';
//       }
//
//       echo
//       '<section class="about-container">
//       <header class="about-header">
//       <h2 id="aboutTitle" class="about-title">' . $about['about_title'] . '</h2>
//       <img id="aboutImage" class="about-image" src="../public/img' . DIRECTORY_SEPARATOR . $about['about_image'] . '">
//       </header>
//       <article id="aboutText" class="about-text">' . $formatted_text . '</article>
//       </section>
//
//       <button id="cvTab">show cv</button>
//       <div id="myModal" class="modal hidden">
//       <button id="closeBtn" class="close cursor">
//       <i class="fa fa-times" aria-hidden="true"></i>
//       </button>
//       <div class="cv-container">
//       <iframe src="../img' . DIRECTORY_SEPARATOR . 'cv.pdf"></iframe>
//       </div>
//       </div>';
//     }
//   }

//   public function display_element() {
//     $element = $_GET['element'];
//     $element_id = $_GET['id'];
//
//     if ($element === 'articles') {
//       $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :element_id', ['element_id' => $element_id]);
//       // JOIN article_categories ON articles.article_id = article_categories.article_id
//
//       $title = 'article_title';
//       $text = 'article_text';
//       $date = 'DATETIME';
//       $image = 'article_image';
//       $author = 'author_id';
//       $categories = "category_names";
//     } else
//     if ($element === 'projects') {
//       $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE projects.project_id = :element_id', ['element_id' => $element_id]);
//
//       $title = 'project_title';
//       $text = 'project_text';
//       $date = 'DATETIME';
//       $image = 'project_image';
//       $author = 'author_id';
//       $categories = "category_names";
//     } else {
//       return;
//     }
//
//     $element = $stmt->fetch();
//     $formatted_date = $element[$date];
//     $formatted_date = date('jS F, Y H:i', strtotime($formatted_date));
//     $paragraphs = explode("\n", $element[$text]);
//     $formatted_text = '';
//
//     foreach ($paragraphs as $paragraph) {
//       $formatted_text .= '<p>' . $paragraph . '</p>';
//     }
//
//     if(isset($_SESSION['logged_in'])) {
//       if ($_SESSION['logged_in'] == true && $element['author_username'] === $_SESSION['user']) {
//         echo '<button id="handler-tab">edit</button>';
//       }
//     }
//
//     echo
//     '<div id="element-' . $element_id . '" class="focus-element-container">
//     <section class="focus-element-header">
//     <img id="image-' . $element_id . '" class="focus-element-image" src="../img' . DIRECTORY_SEPARATOR . $element[$image] . '">
//     </section>
//     <div class="focus-content-container">
//     <h2 id="title-' . $element_id . '" class="focus-element-title">' . $element[$title] . '</h2>
//     <div id="date-' . $element_id . '" class="focus-element-date">on ' . $formatted_date . '</div>
//     <div class="focus-element-username">by ' . $element['author_username'] . '</div>
//     <article id="text-' . $element_id . '" class="focus-element-text">' . $formatted_text . '</article>
//     </div>
//     </div>';
//   }
// }

// class Editor extends Database
// {
//   public function content_handler() {
//     $element = '';
//     $element_type = $_GET['element'];
//     $element_id = $_GET['id'];
//
//     if (basename($_SERVER['SCRIPT_FILENAME']) !== 'create_element.php') {
//       if ($element_type !== 'about') {
//         if ($element_type === 'articles') {
//           $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :element_id', ['element_id' => $element_id]);
//
//           $title = 'article_title';
//           $text = 'article_text';
//           $image = 'article_image';
//           $author_id = 'author_id';
//           $archived = 'article_archived';
//         } elseif ($element_type === 'projects') {
//           $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE project_id = :element_id', ['element_id' => $element_id]);
//
//           $title = 'project_title';
//           $text = 'project_text';
//           $image = 'project_image';
//           $author_id = 'author_id';
//           $archived = 'project_archived';
//         }
//         $element = $stmt->fetch();
//       } else {
//         $stmt = $this->run_query('SELECT * FROM about WHERE about_id = :element_id', ['element_id' => $element_id]);
//         $element = $stmt->fetch();
//
//         $title = 'about_title';
//         $text = 'about_text';
//         $image = 'about_image';
//         $author_id = '1';
//       }
//
//       $username = $_SESSION['user'];
//       $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
//       $author = $stmt->fetch();
//
//       // onsubmit="ajaxSend(this); return false;"
//       echo
//       '<form id="ajax-form" class="hidden" name="editor-form" action="../controllers/content_editor_receiver.php" method="POST" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
//       <fieldset class="ajax-form-container">
//       <legend>element handler</legend>
//       <select id="elementContent" class="" name="content[]">
//       <option value="' . $element_type . '">' . $element_type . '</option>
//       </select>';
//
//       if ($element[$archived]) {
//         echo
//         '<select id="elementArchive" class="" name="archive[]">
//         <option value="' . $element[$archived] . '">archived</option>
//         <option value="' . 0 . '">unarchive</option>
//         </select>';
//       } else {
//         echo
//         '<select id="elementArchive" class="" name="archive[]">
//         <option value="' . $element[$archived] . '">unarchived</option>
//         <option value="' . 1 . '">archive</option>
//         </select>';
//       }
//
//       echo
//       '<input id="elementId" class="" type="number" name="id" value="' . $element_id . '" placeholder="id: ' . $element_id . '">
//       <input id="titleElement" class="" type="text" name="title" value="' . $element[$title] . '" placeholder="title: ' . $element[$title] . '">
//       <input id="elementAuthor" class="" type="number" name="author[]" value="' . $author['author_id'] . '" placeholder="author: ' . $author['author_username'] . '">
//       <input id="elementImage" class="" type="file" multiple name="images[]" value="' . $element[$image] . '">
//       <textarea id="elementText" class="" name="text" cols="50" rows="8" placeholder="">' . $element[$text] . '</textarea>
//       <legend>choose action</legend>
//       <select id="elementAction" class="" name="action[]">
//       <option></option>
//       <option>create</option>
//       <option>edit</option>
//       <option>archive</option>
//       <option>delete</option>
//       </select>
//       <button id="elementSubmit" class="" type="submit" name="button">submit</button>
//       </fieldset>
//       </form>';
//     } else {
//       // query to get articles and projects' last ids
//       $username = $_SESSION['user'];
//       $stmt = $this->run_query('SELECT * FROM authors WHERE author_username = :username', ['username' => $username]);
//       $author = $stmt->fetch();
//
//       echo
//       '<form id="ajax-form" class="" action="../controllers/content_editor_receiver.php" method="POST" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
//       <fieldset class="ajax-form-container">
//       <legend>create element</legend>
//       <select class="" name="content[]">
//       <option value=""></option>
//       <option value="articles">article</option>
//       <option value="projects">project</option>
//       </select>
//       <input class="" type="number" name="id" value="" placeholder="element id:">
//       <input class="" type="text" name="title" value="" placeholder="element title:">
//       <input class="" type="number" name="author" value="' . $author['author_id'] . '" placeholder="author:">
//       <input class="" type="file" multiple name="images[]" value="">
//       <textarea class="" name="text" cols="50" rows="8" placeholder="element text"></textarea>
//       <legend>choose action</legend>
//       <select class="" name="action[]">
//       <option></option>
//       <option>create</option>
//       <option>edit</option>
//       <option>archive</option>
//       <option>delete</option>
//       </select>
//       <button id="elementSubmit" class="" type="submit" name="button">submit</button>
//       </fieldset>
//       </form>';
//     }
//   }
// }
