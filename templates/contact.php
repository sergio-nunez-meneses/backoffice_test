<?php
$title = 'main';
include '../include/header.php';
?>

<main class="main-container">
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
</main>

<p id="ajaxResponse" class="info"></p>

<?php
// if ($_GET['sent'] == 'yes') echo '<p class="info">mail sucessfully sent!</p>';
// elseif ($_GET['sent'] == 'no') echo '<p class="info">failed to send email!</p>';

include '../include/footer.php';
?>

<script src="../public/js/ajax.js"></script>
