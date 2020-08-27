<?php

class EditorModel extends Database
{

  public function get_element_content()
  {
    $id = $type = '';

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id']) && isset($_GET['element']))
    {
      $id = $_GET['id'];
      $element_type = $_GET['element'];

      if ($element_type !== 'about')
      {
        if ($element_type === 'article')
        {
          $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :id', ['id' => $id]);
        } elseif ($element_type === 'project')
        {
          $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE project_id = :id', ['id' => $id]);
        }
        $element = $stmt->fetch();
        return $element;
      } else
      {
        $stmt = $this->run_query('SELECT * FROM about WHERE about_id = :id', ['id' => $id]);
        $element = $stmt->fetch();
        return $element;
      }
    }
  }
}
