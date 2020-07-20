<?php

require_once dirname(dirname(__FILE__)) . '/controllers/class_db.php';

class Element extends Database
{
  public function display_content($element) {
    if ($element !== 'about') {
      if ($element === 'articles') {
        $data = $this->$pdo->query('SELECT * FROM articles ORDER BY article_id DESC LIMIT 10')->fetchAll();

        $id = 'article_id';
        $title = 'article_title';
        $text = 'article_text';
        $date = 'DATETIME';
        $image = 'article_image';
        $author = 'author_id';
      } elseif ($element === 'projects') {
        $data = $this->$pdo->query('SELECT * FROM projects ORDER BY project_id DESC LIMIT 10')->fetchAll();

        $id = 'project_id';
        $title = 'project_title';
        $text = 'project_text';
        $date = 'DATETIME';
        $image = 'project_image';
        $author = 'author_id';
      }
      foreach ($data as $row) {
        echo
        '<article>
        <header>
        <h3><a href="templates/element.php?id=' . $row[$id] . '&element=' . $element .'">' . $row[$title].'</a></h3>
        <img class="" src="' . 'img' . DIRECTORY_SEPARATOR . $row[$image] . '">
        <div class="">
        <div>on ' . $row[$date] . '</div>
        <div>by '  .$row[$author] . '</div>
        </div>
        </header>
        <main>
        <p>' . $row[$text] . '...</p>
        <a class="" href="templates/element.php?id=' . $row[$id] . '&element=' . $element . '">continue reading</a>
        </main>
        </article>';
      }
    } else {
      $stmt = $this->$pdo->prepare('SELECT * FROM about');
      $stmt->execute();
      $about = $stmt->fetch();

      echo
      '<section class="about-container">
      <header>';

      if ($_SESSION['logged_in'] == true && $_SESSION['status'] === 'admin') {
        echo '<button id="handler-tab">edit</button>';
      }

      echo
      '<h2 id="aboutTitle" class="about-title">' . $about['about_title'] . '</h2>
      <img id="aboutImage" class="about-image" src="' . ROOT_DIR . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $about['about_image'] . '">
      </header>
      <article id="aboutText" class="about-text">' . $about['about_text'] . '</article>
      </section>';
    }
  }

  public function display_element() {
    $element = $_GET['element'];
    $element_id = $_GET['id'];

    if ($element === 'articles') {
      $stmt = $this->$pdo->prepare('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :element_id');
      $stmt->execute([
        'element_id' => $element_id
      ]);
      $title = 'article_title';
      $text = 'article_text';
      $date = 'DATETIME';
      $image = 'article_image';
      $author = 'author_id';
    } elseif ($element === 'projects') {
      $stmt = $this->$pdo->prepare('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE project_id = :element_id');
      $stmt->execute([
        'element_id' => $element_id
      ]);
      $title = 'project_title';
      $text = 'project_text';
      $date = 'DATETIME';
      $image = 'project_image';
      $author = 'author_id';
    } else {
      return;
    }

    $element = $stmt->fetch();

    echo
    '<div>
    <header>';

    if(isset($_SESSION['logged_in'])) {
      if ($_SESSION['logged_in'] == true && $element['author_username'] === $_SESSION['user']) {
        echo '<button id="handler-tab">edit</button>';
      }
    }

    echo
    '<h2 id="title-' . $element_id . '" class="">' . $element[$title] . '</h2>
    <img id="image-' . $element_id . '" class="" src="' . dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . $element[$image] . '">
    <div class="">
    <div id="date-' . $element_id . '">on ' . $element[$date] . '</div>
    <div>by ' . $element['author_username'] . '</div>
    </div>
    </header>
    <article id="text-' . $element_id . '">' . $element[$text] . '</article>
    </div>';
  }
}

?>
