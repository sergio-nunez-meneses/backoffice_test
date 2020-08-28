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
    } elseif ($page === 'about') {
      (new AboutController())->display_about();
    } elseif ($page === 'element') {
      (new ElementController())->display_single_element();
    } elseif ($page === 'create') {
      (new EditorController())->create_content();
    }
  } else {
    (new HomeView())->home_view();
  }
  ?>
</main>

<?php include 'include/footer.php'; ?>
