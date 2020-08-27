<?php

class HomeView extends Database
{
  public $title;

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
    <?php
  }
}

(new HomeView())->home_view();
