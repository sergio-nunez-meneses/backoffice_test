<?php

class EditorController extends Database
{

  public function edit_content()
  {
    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['element']))
    {
      $element = $_GET['element'];

      if ($element === 'article')
      {
        $article = (new EditorModel())->get_element_content();
        (new EditorView())->edition_view($article);
      } elseif ($element === 'project')
      {
        $project = (new EditorModel())->get_element_content();
        (new EditorView())->edition_view($project);
      } elseif ($element === 'about')
      {
        $about = (new EditorModel())->get_element_content();
        (new EditorView())->edition_view($about);
      }
    }
  }

  public function create_content()
  {
    if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin' || $_SESSION['status'] === 'collaborator'))
    {
      (new EditorView())->creation_view();
    }
  }
}
