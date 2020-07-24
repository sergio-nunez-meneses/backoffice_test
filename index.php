<?php
$title = 'main';
include 'include/header.php';

// if ($_GET['error'] == '') echo '';
?>

<main class="main-container">

  <div class="container">
    <div class="tab-container">
      <button id="articlesTab" class="">show projects</button>

      <?php

      if ($_SESSION['logged_in'] == true && $_SESSION['status'] === 'admin') {
        echo '<button id="allArticlesTab" class="">show all articles</button>';
      }
      ?>

    </div>

    <!-- <div id="recentArticles" class="content-container"> <?php // display_content('articles'); ?> </div> -->
    <!-- <div id="recentProjects" class="content-container hidden"> <?php // display_content('projects'); ?> </div> -->
    <div id="recentArticles" class="content-container">
      <?php (new Element())->display_content('articles'); ?>
    </div>
    <div id="recentProjects" class="content-container hidden">
      <?php (new Element())->display_content('projects'); ?>
    </div>
    <div id="allArticles" class="content-container hidden">
      <?php (new Element())->display_content('all-articles'); ?>
    </div>
    <div id="allProjects" class="content-container hidden">
      <?php (new Element())->display_content('all-projects'); ?>
    </div>
  </div>

</main>

<?php
include 'include/footer.php';
echo '<script src="public/js/index.js"></script>';
?>
