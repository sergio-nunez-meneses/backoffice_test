<?php

class ElementController
{

  public static function all_elements($elements)
  {
    $element = [];
    $type = substr(explode('_', $elements)[1], 0, -1);
    $prefix = $type . '_';

    if ($elements === 'unarchived_articles')
    {
      $element = (new ElementModel())->get_unarchived_articles();
    } elseif ($elements === 'unarchived_projects')
    {
      $element = (new ElementModel())->get_unarchived_projets();
    } elseif ($elements === 'all_articles')
    {
      $element = (new ElementModel())->get_all_articles();
    } elseif ($elements === 'all_projects')
    {
      $element = (new ElementModel())->get_all_projects();
    }

    foreach ($element as $row) {
      $date = $row['DATETIME'];
      $formatted_date = date('jS F, Y H:i', strtotime($date));
      $text = $row[$prefix . 'text'];
      $shorten_text = substr($text, 0, 80);

      require ABS_PATH . 'templates/allArticlesView.php';
    }
  }

  public static function single_element()
  {
    $id = $type = '';
    $element = [];

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id']) && isset($_GET['element']))
    {
      $id = $_GET['id'];
      $type = $_GET['element'];

      if ($type === 'article')
      {
        $element = (new ElementModel())->get_single_article($id);
      } elseif ($element === 'project')
      {
        $element = (new ElementModel())->get_single_project($id);
      }

      if ($element == true) {
        $prefix = $type . '_';
        $date = $element['DATETIME'];
        $formatted_date = date('jS F, Y H:i', strtotime($date));
        $text = $element[$prefix . 'text'];
        $paragraphs = explode("\n", $text);
        $formatted_text = '';

        foreach ($paragraphs as $paragraph) {
          $formatted_text .= "<p>$paragraph</p>";
        }

        require ABS_PATH . 'templates/singleArticleView.php';
      } else {
        echo 'Element not found';
      }
    }
  }
}
