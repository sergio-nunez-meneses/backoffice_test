<?php
$title = 'main';
include 'include/header.php';
?>

<main class="main-container">
  <?php
  if (isset($_GET['error']) && ($_GET['error'] === 'yes')) {
    echo $_GET['error_message'];
  }

  if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page === 'login') {
      (new UserView())->login_view();
      ?>
      <script src="public/js/login.js"></script>
      <?php
    } elseif ($page === 'about') {
      // code
    } elseif ($page === 'article') {
      (new ArticleController())->display_single_article();
      ?>
      <script src="public/js/ajax.js"></script>
      <?php
    } elseif ($page === 'project') {
      // code
    } elseif ($page === 'create') {
      (new EditorController())->create_content();
      ?>
      <script src="public/js/ajax.js"></script>
      <?php
    }
  } else {
    (new HomeView())->home_view();
    ?>
    <script src="public/js/index.js"></script>
    <?php
  }
  ?>
</main>

<?php include 'include/footer.php'; ?>
