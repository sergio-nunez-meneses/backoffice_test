<?php
$title = 'MVC Test';
include 'include/header.php';

if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['page'])) {
  $page = $_GET['page'];

  if ($page === 'login') {
    UserView::login_view();
  } elseif ($page === 'about') {
    (new AboutController())->display_about();
  } elseif ($page === 'element') {
    (new ElementController())->display_single_element();
  } elseif ($page === 'create') {
    (new EditorController())->create_content();
  } elseif ($page === 'contact') {
    MailView::mail_view();
  }
} else {
  HomeView::home_view();
}

include 'include/footer.php';
