<?php
$title = 'main';
include '../include/header.php';

// if ($_GET['error'] == '') echo '';
?>

<main class="main-container">
  <form id="" class="" action="./controllers/mail.php" method="post" enctype="multipart/form-data"
  onsubmit="ajaxSend(this); return false;">
    <fieldset class="ajax-form-container">
    <legend>send message</legend>
    <input class="" type="text" name="id" value="" placeholder="firstname" required>
    <input class="" type="text" name="title" value="" placeholder="lastname" required>
    <input class="" type="text" name="author" value="" placeholder="email" required>
    <textarea class="" name="text" cols="50" rows="8" placeholder="write me something..."></textarea>
    <input id="" class="" type="submit" name="send" value="send"/>
    </fieldset>
  </form>
</main>
