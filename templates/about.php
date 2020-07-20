<?php
$title = 'about me!';
include '../include/header.php';
?>

<main class="main-container">

  <div class="article-container">
    <?php // display_content('about'); ?>
    <?php (new Element())->display_content('about'); ?>
    <div class="">
      <?php content_handler(); ?>
    </div>
  </div>

</main>

<?php
include '../include/footer.php';

// load ajax or the corresponding script
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo '<script src="public/js/someScript.js"></script>';
} else {
  echo '<script src="../public/js/ajax.js"></script>';
}
?>
