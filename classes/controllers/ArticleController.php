<?php

class ArticleController extends Database
{

  public function display_all_articles($element)
  {
    if ($element === 'unarchived_articles') {
      $articles = (new ArticleModel())->get_unarchived_articles();
      (new ArticleView())->all_articles_view($articles);
    } elseif ($element === 'all_articles') {
      $articles = (new ArticleModel())->get_all_articles();
      (new ArticleView())->all_articles_view($articles);
    }
  }

  public function display_single_article()
  {
    $article = (new ArticleModel())->get_single_article();
    (new ArticleView())->single_article_view($article);
  }
}
