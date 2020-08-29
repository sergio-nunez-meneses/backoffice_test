<?php

class AboutView extends Database
{

  public static function about_view($about)
  {
    $paragraphs = explode("\n", $about['about_text']);
    $formatted_text = '';

    foreach ($paragraphs as $paragraph) {
      $formatted_text .= '<p>' . $paragraph . '</p>';
    }

    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin')) {
      ?>
      <button id="handler-tab">edit</button>
      <?php
    }
    ?>
    <div class="article-container">
      <section class="about-container">
        <header class="about-header">
          <h2 id="aboutTitle" class="about-title"><?php echo $about['about_title']; ?></h2>
          <img id="aboutImage" class="about-image" src="public/img/<?php echo $about['about_image']; ?>">
        </header>
        <article id="aboutText" class="about-text"><?php echo $formatted_text; ?></article>
      </section>
      <button id="cvTab">show cv</button>
      <div id="myModal" class="modal hidden">
        <button id="closeBtn" class="close cursor">
          <i class="fa fa-times" aria-hidden="true"></i>
        </button>
        <div class="cv-container">
          <iframe src="public/img/cv.pdf"></iframe>
        </div>
      </div>
      <div class="">
        <?php (new EditorController())->edit_content(); ?>
        <p id="ajaxResponse" class="info"></p>
      </div>
    </div>
    <script src="public/js/about.js"></script>
    <script src="public/js/ajax.js"></script>
    <?php
  }
}
