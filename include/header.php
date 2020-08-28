<?php
ob_start();
session_start();
define('ABS_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
define('REL_PATH', DIRECTORY_SEPARATOR . basename(ABS_PATH) . DIRECTORY_SEPARATOR);
require_once ABS_PATH . '/include/autoloader_class.php';
require_once ABS_PATH . '/controllers/functions.php';
// require_once ABS_PATH . '/controllers/classes.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="<?php echo base_url(); ?>">
  <link rel="stylesheet" href=" <?php echo REL_PATH . 'public/css/normalize.css'; ?> ">
  <link rel="stylesheet" href=" <?php echo REL_PATH . 'public/css/style.css'; ?> ">
  <script src="https://use.fontawesome.com/275ae55494.js"></script>
  <script src=" <?php echo REL_PATH . 'public/js/functions.js'; ?> "></script>
  <title> <?php echo $title; ?> </title>
</head>

<body>

  <header class="header-container">

    <div class="collapsed-menu">
      <a href=".">
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
        <a href=".">
          <i class="fa fa-home" aria-hidden="true"></i>
          <span class="nav-item">home</span>
        </a>
        <a href=" <?php echo REL_PATH . 'index.php?page=about&element=about&id=1'; ?> ">
          <i class="fa fa-info" aria-hidden="true"></i>
          <span class="nav-item">about</span>
        </a>
        <a href=" <?php echo REL_PATH . 'index.php?page=contact'; ?> " class="">
          <i class="fa fa-envelope" aria-hidden="true"></i>
          <span class="nav-item">contact</span>
        </a>
      </div>
      <div class="navbar-right">
        <?php (new UserController())->is_logged(); ?>
      </div>
    </nav>

  </header>

  <script src=" <?php echo REL_PATH . 'public/js/header.js'; ?> "></script>

  <main>
