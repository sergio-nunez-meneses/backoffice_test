<?php
$title = 'main';
include 'include/header.php';

// if ($_GET['error'] == '') echo '';
?>

<main class="main-container">

  <div class="container">
    <div class="tab-container">
      <button id="articlesTab" class="">show projects</button>
    </div>
    <div id="recentArticles" class="content-container"> <?php display_articles(); ?> </div>
    <div id="recentProjects" class="content-container hidden"> <?php display_projects(); ?> </div>
  </div>

</main>

<?php
include 'include/footer.php';
echo '<script src="public/js/index.js"></script>';
?>
