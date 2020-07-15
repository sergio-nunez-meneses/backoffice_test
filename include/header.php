<?php

session_start();
define('__ROOT__', dirname(dirname(__FILE__)));
require_once __ROOT__ . '/controllers/functions.php';

// error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="public/css/style.css">
  <script src="public/js/functions.js"></script>
  <title> <?php echo $title; ?> </title>
</head>

<body>

  <header class="header-container">

    <a href="/backoffice_test/index.php">home</a>
    <?php isLogged(); ?>

  </header>
