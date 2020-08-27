<?php
$title = 'sign';
include '../include/header.php';

if (isset($_GET['error']) && ($_GET['error'] === 'yes')) {
  echo $_GET['error_message'];
}
?>
<main class="main-container">
  <?php
  if (isset($_GET['page'])) {
    $page = $_GET['page'];

  	switch($page) {
  		case 'login' :
        require_once __ROOT__ . '/classes/models/UserModel.php';
        require_once __ROOT__ . '/classes/views/UserView.php';
  		break;

  		default :
  			header('index.php');
  	}
  }
  ?>
</main>

<?php
echo '<script src="' . __ROOT__ . '/public/js/login.js"></script>';

include '../include/footer.php';
?>
