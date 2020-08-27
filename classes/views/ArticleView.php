<?php

class ArticleView extends Database
{

  public function all_articles_view($articles)
  {
    foreach ($articles as $row) {
      $date = $row['DATETIME'];
      $formatted_date = date('jS F, Y H:i', strtotime($date));
      $text = $row['article_text'];
      $shorten_text = substr($text, 0, 80);
      ?>
      <section class="element-box">
        <img class="element-image" src="public/img/<?php echo $row['article_image']; ?>">
        <div class="transparent-box">
          <article class="element-caption">
            <header>
              <h3>
                <a class="element-title" href="index.php?page=article&id=<?php echo $row['article_id']; ?>">
                  <?php echo $row['article_title']; ?>
                </a>
              </h3>
              <div class="">
                <p class="element-date">On <?php echo $formatted_date; ?></p>
                <p class="element-author">By <?php echo (new UserModel())->get_username($row['author_id']); ?></p>
              </div>
            </header>
            <main>
              <p><?php echo $shorten_text; ?></p>
              <a class="opacity-low" href="index.php?page=article&id=<?php echo $row['article_id']; ?>">
                continue reading
              </a>
            </main>
          </article>
        </div>
      </section>
      <?php
    }
  }

  public function single_article_view($article)
  {
    $date = $article['DATETIME'];
    $formatted_date = date('jS F, Y H:i', strtotime($date));
    $text = $article['article_text'];
    $paragraphs = explode("\n", $text);
    $formatted_text = '';

    foreach ($paragraphs as $paragraph) {
      $formatted_text .= "<p>$paragraph</p>";
    }

    if(isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && $_SESSION['status'] === 'admin')
    {
      ?>
      <button id="handler-tab">edit</button>
      <?php
    }
    ?>
    <div id="element-<?php echo $article['article_id']; ?>" class="focus-element-container">
      <section class="focus-element-header">
        <img id="image-<?php echo $article['article_id']; ?>" class="focus-element-image" src="public/img/<?php echo $article['article_image']; ?>">
      </section>
      <div class="focus-content-container">
        <h2 id="title-<?php echo $article['article_id']; ?>" class="focus-element-title"><?php echo $article['article_title']; ?></h2>
        <p id="date-<?php echo $article['article_id']; ?>" class="focus-element-date">On <?php echo $formatted_date; ?></p>
        <p class="focus-element-username">By <?php echo (new UserModel())->get_username($article['author_id']); ?></p>
        <article id="text-<?php echo $article['article_id']; ?>" class="focus-element-text"><?php echo $formatted_text; ?></article>
      </div>
    </div>
    <?php
  }
}
