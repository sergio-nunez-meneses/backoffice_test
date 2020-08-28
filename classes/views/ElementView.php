<?php

class ElementView extends Database
{

  public function all_elements_view($articles, $elements)
  {
    $element = substr($elements, 0, -1);
    $prefix = $element . '_';

    foreach ($articles as $row) {
      $date = $row['DATETIME'];
      $formatted_date = date('jS F, Y H:i', strtotime($date));
      $text = $row[$prefix . 'text'];
      $shorten_text = substr($text, 0, 80);
      ?>
      <section class="element-box">
        <img class="element-image" src="public/img/<?php echo $row[$prefix . 'image']; ?>">
        <div class="transparent-box">
          <article class="element-caption">
            <header>
              <h3>
                <a class="element-title" href="index.php?page=element&element=<?php echo $element; ?>&id=<?php echo $row[$prefix . 'id']; ?>">
                  <?php echo $row[$prefix . 'title']; ?>
                </a>
              </h3>
              <div class="">
                <p class="element-date">On <?php echo $formatted_date; ?></p>
                <p class="element-author">By <?php echo (new UserModel())->get_username($row['author_id']); ?></p>
              </div>
            </header>
            <main>
              <p><?php echo $shorten_text; ?></p>
              <a class="opacity-low" href="index.php?page=element&element=<?php echo $element; ?>&id=<?php echo $row[$prefix . 'id']; ?>">
                continue reading
              </a>
            </main>
          </article>
        </div>
      </section>
      <?php
    }
  }

  public function single_element_view($article, $element)
  {
    $prefix = $element . '_';
    $date = $article['DATETIME'];
    $formatted_date = date('jS F, Y H:i', strtotime($date));
    $text = $article[$prefix . 'text'];
    $paragraphs = explode("\n", $text);
    $formatted_text = '';

    foreach ($paragraphs as $paragraph) {
      $formatted_text .= "<p>$paragraph</p>";
    }

    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin'))
    {
      ?>
      <button id="handler-tab">edit</button>
      <?php
    }
    ?>
    <div class="article-container">
      <div id="element-<?php echo $article[$prefix . 'id']; ?>" class="focus-element-container">
        <section class="focus-element-header">
          <img id="image-<?php echo $article[$prefix . 'id']; ?>" class="focus-element-image" src="public/img/<?php echo $article[$prefix . 'image']; ?>">
        </section>
        <div class="focus-content-container">
          <h2 id="title-<?php echo $article[$prefix . 'id']; ?>" class="focus-element-title"><?php echo $article[$prefix . 'title']; ?></h2>
          <p id="date-<?php echo $article[$prefix . 'id']; ?>" class="focus-element-date">On <?php echo $formatted_date; ?></p>
          <p class="focus-element-username">By <?php echo (new UserModel())->get_username($article['author_id']); ?></p>
          <article id="text-<?php echo $article[$prefix . 'id']; ?>" class="focus-element-text"><?php echo $formatted_text; ?></article>
        </div>
      </div>
      <div class="">
        <?php (new EditorController())->edit_content(); ?>
        <p id="ajaxResponse" class="info"></p>
      </div>
    </div>
    <script src="public/js/ajax.js"></script>
    <?php
  }
}
