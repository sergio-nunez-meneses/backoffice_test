<?php
$title = 'main';
include 'include/header.php';
?>

<main class="main-container">
  <?php
  if (isset($_GET['error']) && ($_GET['error'] === 'yes')) {
    echo $_GET['error_message'];
  }

  if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'login') {
      require_once ABS_PATH . '/classes/models/UserModel.php';
      require_once ABS_PATH . '/classes/controllers/UserController.php';
      require_once ABS_PATH . '/classes/views/UserView.php';
      ?>
      <script src="public/js/login.js"></script>
      <?php
    } elseif ($page === 'about') {
      // code...
    }
  } else {
    require_once ABS_PATH . '/classes/views/HomeView.php';
    ?>
    <script src="public/js/index.js"></script>
    <?php
  }
  ?>
</main>

<?php include 'include/footer.php'; ?>
