<?php
$title = 'about me!';
include '../include/header.php';
?>

<main class="main-container">

  <div class="article-container">
    <?php // display_content('about'); ?>
    <?php (new Element())->display_content('about'); ?>
    <div class="">
      <?php // content_handler(); ?>
      <?php (new Editor())->content_handler(); ?>
    </div>
  </div>

</main>

<?php
echo '<p id="ajaxResponse" class="info"></p>
<script src="../public/js/about.js"></script>';

// load ajax or the corresponding script
if (isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo '<script src="../public/js/ajax.js"></script>';
}

include '../include/footer.php';
?>
