<?php
$title = 'MVC Test';
include 'include/header.php';

if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['page'])) {
  $page = explode('/', $_GET['page']);

  if ($page[0] === 'login') {
    UserController::sign_in();
    // require 'templates/loginView.php';
  } elseif ($page[0] === 'about') {
    AboutController::process_data();
  } elseif ($page[0] === 'element') {
    ElementController::single_element();
  } elseif ($page[0] === 'create') {
    EditorController::create_content();
  } elseif ($page[0] === 'contact') {
    MailController::send_mail();
  } else {
    require 'templates/homeView.php';
  }
}

include 'include/footer.php';
