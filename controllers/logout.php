<?php
$title = 'logout';
include '../include/header.php';
?>

<main class="main-container">
  <?php // logout(); ?>
  <?php $user->logout(); ?>
</main>

<?php include '../include/footer.php'; ?>
