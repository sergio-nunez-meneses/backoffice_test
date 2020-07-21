<?php
session_start();

define('__ROOT__', dirname(dirname(__FILE__)));
define('ROOT_DIR', '/' . basename(__ROOT__));
require_once __ROOT__ . '/controllers/functions.php';
require_once __ROOT__ . '/controllers/classes.php';

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

$user = new User();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href=" <?php echo ROOT_DIR . '/public/css/normalize.css'; ?> ">
  <link rel="stylesheet" href=" <?php echo ROOT_DIR . '/public/css/style.css'; ?> ">
  <script src=" <?php echo ROOT_DIR . '/public/js/functions.js'; ?> "></script>
  <title> <?php echo $title; ?> </title>
</head>

<body>

  <header class="header-container">

    <a href=" <?php echo ROOT_DIR . '/index.php'; ?> ">
      <span class="">home</span>
    </a>
    <a href=" <?php echo ROOT_DIR . '/templates/about.php?id=1&element=about'; ?> ">
      <span class="">about</span>
    </a>
    <a href=" <?php echo ROOT_DIR . '/templates/contact.php'; ?> " class="">
      <span class="">contact</span>
    </a>
    <?php // is_logged(); ?>
    <?php $user->is_logged(); ?>

  </header>
