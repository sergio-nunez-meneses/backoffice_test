<?php
$title = 'main';
include 'include/header.php';
?>

<main class="main-container">
  <?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'login') {
      require_once __ROOT__ . '/classes/models/UserModel.php';
      require_once __ROOT__ . '/classes/views/UserView.php';
      ?>
      <script src="public/js/login.js"></script>
      <?php
    }
  } else {
    require_once __ROOT__ . '/classes/views/HomeView.php';
    ?>
    <script src="public/js/index.js"></script>
    <?php
  }
  ?>
</main>

<?php include 'include/footer.php'; ?>
