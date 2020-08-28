<?php

function base_url() {
  $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
  $domain = $_SERVER['SERVER_NAME'];
  $url = "${protocol}://${domain}/" . basename(dirname($_SERVER['SCRIPT_FILENAME'])) . '/';
  return $url;
}

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

// function ajax_receiver() {
//   $pdo = connection();
//   $form = 'ajax-element-form';
//   $section = $element_type = $action = $action_message = $error_message = '';
//   $error = false;
//
//   date_default_timezone_set('Europe/Paris');
//
//   if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     $error = true;
//     $error_message .= 'sign in to edit this article <br>';
//   } else {
//
//     if (empty($_POST['title'])) {
//       $error_message .= 'title cannot be empty <br>';
//       $error = true;
//     } elseif (strlen($_POST['title']) < 5) {
//       $error_message .= 'title must contain more than 5 characters <br>';
//       $error = true;
//     } else {
//       $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
//     }
//
//     if (empty($_POST['text'])) {
//       $error_message .= 'text cannot be empty <br>';
//       $error = true;
//     } elseif (strlen($_POST['text']) < 10){
//       $error_message .= 'text must contain more than 10 characters <br>';
//       $error = true;
//     } else {
//       $element_text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
//     }
//
//     if (!$error) {
//       $element_type = $_POST['content'][0];
//       $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
//       $element_date = filter_var(substr(date("Y-m-d H:i:sa"), 0, -2), FILTER_SANITIZE_STRING);
//       $image_dir = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
//       $element_image = filter_var($_FILES['images']['name'][0], FILTER_SANITIZE_STRING);
//
//       move_uploaded_file($_FILES['images']['tmp_name'][0], $image_dir . $element_image);
//
//       $username = $_SESSION['user'];
//       $stmt = $pdo->prepare('SELECT author_id FROM authors WHERE author_username = :username');
//       $stmt->execute([
//         'username' => $username
//       ]);
//       $author = $stmt->fetch();
//       $author_id = $author['author_id'];
//
//       if ($_POST['action'][0] === 'create') {
//         $element_archived = 0;
//         if ($_POST['content'][0] === 'articles') {
//           $section = $_POST['content'][0];
//
//           $pdo->prepare('INSERT INTO articles VALUES (:element_id, :element_title, :element_text, :element_date, :element_image, :author_id, :element_archived)')->execute([
//             'element_id' => $element_id,
//             'element_title' => $element_title,
//             'element_text' => $element_text,
//             'element_date' => $element_date,
//             'element_image' => $element_image,
//             'author_id' => $author_id,
//             'element_archived' => $element_archived
//           ]);
//         } elseif ($_POST['content'][0] === 'projects') {
//           // edit project
//           // $section = $_POST['content'][0];
//         }
//
//         $action = $_POST['action'][0];
//         $action_message = 'element created <br>';
//
//       } elseif ($_POST['action'][0] === 'edit') {
//         $element_archived = $_POST['archive'][0];
//
//         if ($_POST['content'][0] === 'about') {
//           $section = $_POST['content'][0];
//
//           $pdo->prepare('UPDATE about SET about_title = :element_title, about_image = :element_image, about_text = :element_text WHERE about_id = :element_id')->execute([
//             'element_title' => $element_title,
//             'element_image' => $element_image,
//             'element_text' => $element_text,
//             'element_id' => $element_id
//           ]);
//         } elseif ($_POST['content'][0] === 'articles') {
//           $section = $_POST['content'][0];
//
//           $pdo->prepare('UPDATE articles SET article_title = :element_title, article_text = :element_text, DATETIME = :element_date, article_image = :element_image, author_id = :author_id, article_archived = :element_archived WHERE article_id = :element_id')->execute([
//             'element_title' => $element_title,
//             'element_text' => $element_text,
//             'element_date' => $element_date,
//             'element_image' => $element_image,
//             'author_id' => $author_id,
//             'element_archived' => $element_archived,
//             'element_id' => $element_id
//           ]);
//         } elseif ($_POST['content'][0] === 'projects') {
//           // update project
//           // $section = $_POST['content'][0];
//         }
//
//         $action = $_POST['action'][0];
//         $action_message = 'element edited <br>';
//
//       } elseif ($_POST['action'][0] === 'archive') {
//         $element_archived = 1;
//
//         if ($_POST['content'][0] === 'articles') {
//           $section = $_POST['content'][0];
//
//           $pdo->prepare('UPDATE articles SET article_archived = :element_archived WHERE article_id = :element_id')->execute([
//             'element_archived' => $element_archived,
//             'element_id' => $element_id
//           ]);
//
//           $pdo->prepare('INSERT INTO archives VALUES (NULL, :element_title, :element_text, :element_date, :element_image, :author_id, :element_id)')->execute([
//             'element_title' => $element_title,
//             'element_text' => $element_text,
//             'element_date' => $element_date,
//             'element_image' => $element_image,
//             'author_id' => $author_id,
//             'element_id' => $element_id
//           ]);
//         } elseif ($_POST['content'][0] === 'projects') {
//           $section = $_POST['content'][0];
//           //
//         }
//
//         $action = $_POST['action'][0];
//         $action_message = 'element archived <br>';
//
//       } elseif ($_POST['action'][0] === 'delete') {
//         if ($_POST['content'][0] === 'articles') {
//           $pdo->prepare('DELETE FROM articles WHERE article_id = :element_id')->execute([
//             'element_id' => $element_id
//           ]);
//         } elseif ($_POST['content'][0] === 'projects') {
//           $pdo->prepare('DELETE FROM projects WHERE project_id = :element_id')->execute([
//             'element_id' => $element_id
//           ]);
//         }
//
//         $action = $_POST['action'][0];
//         $action_message = 'element deleted <br>';
//
//       }
//     } else {
//       $error_message .= 'could not perform requested action <br>';
//     }
//
//     // back to ajax.js
//     $array = [
//       'form' => $form,
//       'action' => $action,
//       'action_message' => $action_message,
//       'element' => $element_type,
//       'id' => $element_id,
//       'title' => $element_title,
//       'text' => $element_text,
//       'date' => $element_date,
//       'image' => $element_image,
//       'author' => $author_id
//     ];
//     echo json_encode($array);
//     // var_dump($array);
//
//   }
// }

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
