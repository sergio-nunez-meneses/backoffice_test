<?php

class ElementController extends Database
{

  public function display_all_elements($elements)
  {
    $element = explode('_', $elements)[1];

    if ($elements === 'unarchived_articles')
    {
      $articles = (new ElementModel($elements))->get_unarchived_articles();
      (new ElementView())->all_elements_view($articles, $element);
    } elseif ($elements === 'unarchived_projects')
    {
      $projects = (new ElementModel($elements))->get_unarchived_projets();
      (new ElementView())->all_elements_view($projects, $element);
    } elseif ($elements === 'all_articles')
    {
      $articles = (new ElementModel())->get_all_articles();
      (new ElementView())->all_elements_view($articles, $element);
    } elseif ($elements === 'all_projects')
    {
      $projects = (new ElementModel())->get_all_projects();
      (new ElementView())->all_elements_view($projects, $element);
    }
  }

  public function display_single_element()
  {
    $project_id = '';

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id']) && isset($_GET['element']))
    {
      $element = $_GET['element'];

      if ($element === 'article')
      {
        $article = (new ElementModel())->get_single_article();
        (new ElementView())->single_element_view($article, $element);
      } elseif ($element === 'project')
      {
        $project = (new ElementModel())->get_single_project();
        (new ElementView())->single_element_view($project, $element);
      }
    }
  }
}
