<?php
session_start();

define('__ROOT__', dirname(dirname(__FILE__)));
define('ROOT_DIR', '/' . basename(__ROOT__));
require_once __ROOT__ . '/controllers/functions.php';
require_once __ROOT__ . '/classes/abstract/db.php';
require_once __ROOT__ . '/controllers/classes.php';
require_once __ROOT__ . '/classes/controllers/UserController.php';

$user = new UserController();
echo base_url();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?php echo base_url(); ?>">
  <link rel="stylesheet" href=" <?php echo ROOT_DIR . '/public/css/normalize.css'; ?> ">
  <link rel="stylesheet" href=" <?php echo ROOT_DIR . '/public/css/style.css'; ?> ">
  <script src="https://use.fontawesome.com/275ae55494.js"></script>
  <script src=" <?php echo ROOT_DIR . '/public/js/functions.js'; ?> "></script>
  <title> <?php echo $title; ?> </title>
</head>

<body>

  <header class="header-container">

    <div class="collapsed-menu">
      <a href=" <?php echo ROOT_DIR . '/index.php'; ?> ">
        <h3><strong class="heading-text">sergio núñez meneses</strong></h3>
      </a>
      <button id="navbarTab" class="navbar-toggle" type="button"><i class="fa fa-bars" aria-hidden="true"></i>
      </button>
    </div>

    <div id="presentationText" class="presentation-text">
      <small><em class="nav-text">composer, computer music designer, web development student, and future phd student</em></small>
    </div>

    <nav id="navbarContainer" class="navbar-container">
      <div class="navbar-left">
        <a href=" <?php echo ROOT_DIR . '/index.php'; ?> ">
          <i class="fa fa-home" aria-hidden="true"></i>
          <span class="nav-item">home</span>
        </a>
        <a href=" <?php echo ROOT_DIR . '/templates/about.php?id=1&element=about'; ?> ">
          <i class="fa fa-info" aria-hidden="true"></i>
          <span class="nav-item">about</span>
        </a>
        <a href=" <?php echo ROOT_DIR . '/templates/contact.php'; ?> " class="">
          <i class="fa fa-envelope" aria-hidden="true"></i>
          <span class="nav-item">contact</span>
        </a>
      </div>
      <div class="navbar-right">
        <?php // is_logged(); ?>
        <?php $user->is_logged(); ?>
      </div>
    </nav>

  </header>

  <main>

  <script src=" <?php echo ROOT_DIR . '/public/js/header.js'; ?> "></script>
