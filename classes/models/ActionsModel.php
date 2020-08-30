<?php

class ActionsModel extends Database
{

  public function check_user($user_id)
  {
    $stmt = $this->run_query('SELECT author_id FROM authors WHERE author_id = :user_id', ['user_id' => $user_id]);
    $author = $stmt->fetch();

    if ($user_id == $author['author_id'])
    {
      return true;
    } else
    {
      return false;
    }
  }

  public function create_article($element_title, $element_text, $element_image, $author_id, $element_archived)
  {
    $this->run_query('INSERT INTO articles VALUES (NULL, :element_title, :element_text, NOW(), :element_image, :author_id, :element_archived)', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_archived' => $element_archived,
    ]);
  }

  public function update_article($element_title, $element_text, $element_image, $author_id, $element_archived, $element_id)
  {
    $this->run_query('UPDATE articles SET article_title = :element_title, article_text = :element_text, DATETIME = NOW(), article_image = :element_image, author_id = :author_id, article_archived = :element_archived WHERE article_id = :element_id', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_archived' => $element_archived,
      'element_id' => $element_id,
    ]);
  }

  public function archive_article($element_id, $element_title, $element_text, $element_image, $author_id, $element_archived)
  {
    $this->run_query('UPDATE articles SET article_archived = :element_archived WHERE article_id = :element_id', [
      'element_archived' => $element_archived,
      'element_id' => $element_id,
    ]);
    $this->run_query('INSERT INTO archives VALUES (NULL, :element_title, :element_text, NOW(), :element_image, :author_id, :element_id)', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_id' => $element_id,
    ]);
  }

  public function delete_article($element_id)
  {
    $this->run_query('DELETE FROM articles WHERE article_id = :element_id', ['element_id' => $element_id]);
  }

  public function create_project($element_title, $element_text, $element_image, $author_id, $element_archived)
  {
    $this->run_query('INSERT INTO projects VALUES (NULL, :element_title, :element_text, NOW(), :element_image, :author_id, :element_archived)', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_archived' => $element_archived,
    ]);
  }

  public function update_project($element_title, $element_text, $element_image, $author_id, $element_archived, $element_id)
  {
    $this->run_query('UPDATE projects SET project_title = :element_title, project_text = :element_text, DATETIME = NOW(), project_image = :element_image, author_id = :author_id, project_archived = :element_archived WHERE project_id = :element_id', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_archived' => $element_archived,
      'element_id' => $element_id,
    ]);
  }

  public function archive_project($element_id, $element_title, $element_image, $author_id, $element_archived)
  {
    $this->run_query('UPDATE projects SET article_archived = :element_archived WHERE article_id = :element_id', [
      'element_archived' => $element_archived,
      'element_id' => $element_id,
    ]);
    $this->run_query('INSERT INTO archives VALUES (NULL, :element_title, :element_text, NOW(), :element_image, :author_id, :element_id)', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
      'element_id' => $element_id,
    ]);
  }

  public function delete_project($element_id)
  {
    $this->run_query('DELETE FROM projects WHERE project_id = :element_id', ['element_id' => $element_id]);
  }

  public function create_bio($element_title, $element_text, $element_image, $author_id)
  {
    $this->run_query('INSERT INTO about VALUES (NULL, :element_title, :element_text, :element_image, :author_id)', [
      'element_title' => $element_title,
      'element_text' => $element_text,
      'element_image' => $element_image,
      'author_id' => $author_id,
    ]);
  }

  public function update_bio($element_title, $element_image, $element_text, $element_id)
  {
    $this->run_query('UPDATE about SET about_title = :element_title, about_image = :element_image, about_text = :element_text WHERE about_id = :element_id', [
      'element_title' => $element_title,
      'element_image' => $element_image,
      'element_text' => $element_text,
      'element_id' => $element_id,
    ]);
  }
}
