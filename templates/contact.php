<?php
$title = 'contact me!';
include '../include/header.php';
?>

<main class="main-container">

  <div class="contact-container">
    <button id="mail-tab">recover password</button>
    <!-- contact -->
    <form id="ajax-mail-form" class="" action=" <?php echo ROOT_DIR . '/controllers/mail.php'; ?> " method="post" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
      <legend>send message</legend>
      <input class="" type="text" name="firstname" value="" placeholder="firstname" required>
      <input class="" type="text" name="lastname" value="" placeholder="lastname" required>
      <input class="" type="text" name="email" value="" placeholder="email" required>
      <textarea class="" name="message" cols="50" rows="8" placeholder="write me something..."></textarea>
      <input id="" class="" type="submit" name="send-message" value="send"/>
      </fieldset>
    </form>
    <!-- recover password -->
    <form id="ajax-recover-form" class="hidden" action=" <?php echo ROOT_DIR . '/controllers/mail.php'; ?> " method="post" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
      <legend>recover password</legend>
      <input class="" type="number" name="id" value="" placeholder="id" required>
      <input class="" type="text" name="firstname" value="" placeholder="firstname" required>
      <input class="" type="text" name="email" value="" placeholder="email" required>
      <input id="" class="" type="submit" name="recover-password" value="send"/>
      </fieldset>
    </form>
  </div>

</main>

<p id="ajaxResponse" class="info"></p>

<?php include '../include/footer.php'; ?>

<script src="../public/js/ajax.js"></script>
