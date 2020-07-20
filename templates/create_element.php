<?php
$title = 'create element';
include '../include/header.php';
?>

<main class="main-container">

  <div id="newArticleContainer" class="article-container">
    <div>
      <?php (new Editor())->content_handler(); ?>
    </div>
  </div>

</main>

<?php
echo '<p id="ajaxResponse" class="info"></p>';

// load ajax or the corresponding script
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo '<script src="public/js/someScript.js"></script>';
} else {
  echo '<script src="../public/js/ajax.js"></script>';
}

include 'include/footer.php';
?>
