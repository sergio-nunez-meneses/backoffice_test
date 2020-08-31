<?php

class EditorModel extends Database
{

  public function get_element_content($type, $id)
  {
    $element = [];
    if ($type !== 'about')
    {
      if ($type === 'article')
      {
        $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE article_id = :id', ['id' => $id]);
      } elseif ($type === 'project')
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
