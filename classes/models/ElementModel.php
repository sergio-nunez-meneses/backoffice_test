<?php

class ElementModel extends Database
{

  public function get_unarchived_articles()
  {
    $articles = $this->run_query('SELECT * FROM articles WHERE article_archived = 0 ORDER BY article_id DESC LIMIT 6')->fetchAll();
    return $articles;
  }

  public function get_unarchived_projets()
  {
    $projects = $this->run_query('SELECT * FROM projects WHERE project_archived = 0 ORDER BY project_id DESC LIMIT 6')->fetchAll();
    return $projects;
  }

  public function get_all_articles()
  {
    $articles = $this->run_query('SELECT * FROM articles ORDER BY article_id DESC')->fetchAll();
    return $articles;
  }

  public function get_all_projects()
  {
    $projects = $this->run_query('SELECT * FROM projects ORDER BY project_id DESC')->fetchAll();
    return $projects;
  }

  public function get_single_article($id)
  {
    $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :id', ['id' => $id]);
    $article = $stmt->fetch();
    return $article;
  }

  public function get_single_project($id)
  {
    $stmt = $this->run_query('SELECT * FROM projects JOIN authors ON projects.author_id = authors.author_id WHERE projects.project_id = :id', ['id' => $id]);
    $project = $stmt->fetch();
    return $project;
  }

  public function get_last_article()
  {
    $last_id = $this->run_query('SELECT article_id FROM articles ORDER BY article_id DESC LIMIT 1')->fetchAll();
    return $last_id['article_id'];
  }
}
