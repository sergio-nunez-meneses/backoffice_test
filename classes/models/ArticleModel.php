<?php

class ArticleModel extends Database
{

  public function get_unarchived_articles()
  {
    $articles = $this->run_query('SELECT * FROM articles WHERE article_archived = 0 ORDER BY article_id DESC LIMIT 6')->fetchAll();
    return $articles;
  }

  public function get_all_articles()
  {
    $articles = $this->run_query('SELECT * FROM articles ORDER BY article_id DESC')->fetchAll();
    return $articles;
  }

  public function get_single_article()
  {
    $article_id = '';

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id'])) {
      $article_id = $_GET['id'];
      $stmt = $this->run_query('SELECT * FROM articles JOIN authors ON articles.author_id = authors.author_id WHERE articles.article_id = :article_id', ['article_id' => $article_id]);
      $article = $stmt->fetch();
      return $article;
    }
  }

  public function get_last_article()
  {
    $last_id = $this->run_query('SELECT article_id FROM articles ORDER BY article_id DESC LIMIT 1')->fetchAll();
    return $last_id['article_id'];
  }
}
