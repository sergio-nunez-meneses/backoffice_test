<?php
$title = 'main';
include 'include/header.php';

// if ($_GET['error'] == '') echo '';
?>

<main class="main-container">

  <div class="container">
    <div class="tab-container">
      <button id="articlesTab" class="">articles</button>
      <button id="projectsTab" class="">projects</button>
    </div>
    <div id="recentArticles" class="content-container"> <?php articles(); ?> </div>
    <div id="recentProjects" class="content-container hidden"> <?php projects(); ?> </div>
  </div>

</main>

<?php include 'include/footer.php'; ?>

<script src="public/js/index.js"></script>
