<?php

class EditorController
{

  public static function edit_content()
  {
    $id = $type = $prefix = '';
    $element = [];

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id']) && isset($_GET['element']))
    {
      $id = $_GET['id'];
      $type = $_GET['element'];
      $prefix = $type . '_';

      if ($type === 'article')
      {
        $element = (new EditorModel())->get_element_content($type, $id);
      } elseif ($type === 'project')
      {
        $element = (new EditorModel())->get_element_content($type, $id);
      } elseif ($type === 'about')
      {
        $element = (new EditorModel())->get_element_content($type, $id);
      }
      require ABS_PATH . 'templates/editionView.php';
    }
  }

  public static function create_content()
  {
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin' || $_SESSION['status'] === 'collaborator'))
    {
      require ABS_PATH . 'templates/creationView.php';
    }
  }
}
