<div class="container">
  <div class="tab-container">
    <button id="articlesTab" class="">show projects</button>
    <?php
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin')) {
      ?>
      <button id="allArticlesTab" class="">show all articles</button>
      <?php
    }
    ?>
  </div>
  <div id="recentArticles" class="content-container">
    <?php ElementController::all_elements('unarchived_articles'); ?>
  </div>
  <div id="recentProjects" class="content-container hidden">
    <?php ElementController::all_elements('unarchived_projects'); ?>
  </div>
  <div id="allArticles" class="content-container hidden">
    <?php ElementController::all_elements('all_articles'); ?>
  </div>
  <div id="allProjects" class="content-container hidden">
    <?php ElementController::all_elements('all_projects'); ?>
  </div>
</div>
<script src="/public/js/index.js"></script>
