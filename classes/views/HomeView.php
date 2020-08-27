<?php

class HomeView extends Database
{
  public function home_view()
  {
    ?>
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
        <?php (new ArticleController())->display_all_articles('unarchived_articles'); ?>
      </div>
      <div id="recentProjects" class="content-container hidden">
        <?php (new Element())->display_content('projects'); ?>
      </div>
      <div id="allArticles" class="content-container hidden">
        <?php (new ArticleController())->display_all_articles('all_articles'); ?>
      </div>
      <div id="allProjects" class="content-container hidden">
        <?php (new Element())->display_content('all-projects'); ?>
      </div>
    </div>
    <?php
  }
}
