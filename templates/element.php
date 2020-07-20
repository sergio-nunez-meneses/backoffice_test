<?php
$title = $_GET['element'] . ' ' . $_GET['id'];
include '../include/header.php';
?>

<main class="main-container">

  <div class="article-container">
    <?php display_element(); ?>
    <div class="">
      <?php content_handler(); ?>
    </div>
  </div>

</main>

<?php
echo '<p id="ajaxResponse" class="info"></p>';

include '../include/footer.php';

// load ajax or the corresponding script
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo '<script src="../public/js/someScript.js"></script>';
} else {
  echo '<script src="../public/js/ajax.js"></script>';
}
?>
