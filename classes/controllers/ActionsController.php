<?php

class ActionsController
{

  public static function create_element()
  {
    // $form = 'ajax-element-form';
    $error = false;
    $author_id = $element_id = $element_type = $element_title = $element_text = $action = $action_msg = $error_msg = '';

    date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= 'sign in to create an element';
    } else
    {
      if (empty($_POST['title']))
      {
        $error = true;
        $error_msg .= 'title cannot be empty';
      } elseif (strlen($_POST['title']) < 5)
      {
        $error = true;
        $error_msg .= 'title must contain more than 5 characters';
      } else
      {
        $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['text']))
      {
        $error = true;
        $error_msg .= 'text cannot be empty';
      } elseif (strlen($_POST['text']) < 10){
        $error = true;
        $error_msg .= 'text must contain more than 10 characters';
      } else
      {
        $element_text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
      }

      if (empty($_FILES['images']['name'][0]))
      {
        $image = filter_var($_POST['stored_image'], FILTER_SANITIZE_STRING);
      } elseif (empty($_POST['stored_image']))
      {
        $image = filter_var($_FILES['images']['name'][0], FILTER_SANITIZE_STRING);
      }

      if (!$error)
      {
        if ((new ActionsModel())->check_user($_POST['author']))
        {
          $author_id = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
          $action = $_POST['action'][0];
          $section = $_POST['content'][0];
          $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
          $element_date = filter_var(substr(date("Y-m-d H:i:sa"), 0, -2), FILTER_SANITIZE_STRING);
          $image_dir = 'public/img/';
          $element_image = filter_var($image, FILTER_SANITIZE_STRING);
          move_uploaded_file($_FILES['images']['tmp_name'][0], $image_dir . $element_image);

          if ($action === 'create')
          {
            $element_archived = 0;

            if ($section === 'articles')
            {
              (new ActionsModel())->create_article($element_title, $element_text, $element_image, $author_id, $element_archived);
            }
            $action_msg .= 'element created';
            header('Location:/?result=' . urlencode($action_msg));
          }
        } else
        {
          $error_msg .= "you are not allowed to $action content";
          header('Location:/create?result=' . urlencode($error_msg));
          echo "$error_msg<br>";
        }
      } else
      {
        $error_msg .= 'could not perform requested action';
        header('Location:/create?result=' . urlencode($error_msg));
        echo "$error_msg<br>";
      }
    }
  }

  public static function edit_element()
  {
    // $form = 'ajax-element-form';
    $error = false;
    $author_id = $element_id = $element_type = $element_title = $element_text = $action = $action_msg = $error_msg = '';

    date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= 'sign in to edit this element';
    } else
    {
      if (empty($_POST['title']))
      {
        $error = true;
        $error_msg .= 'title cannot be empty';
      } elseif (strlen($_POST['title']) < 5)
      {
        $error = true;
        $error_msg .= 'title must contain more than 5 characters';
      } else
      {
        $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['text']))
      {
        $error = true;
        $error_msg .= 'text cannot be empty';
      } elseif (strlen($_POST['text']) < 10){
        $error = true;
        $error_msg .= 'text must contain more than 10 characters';
      } else
      {
        $element_text = filter_var($_POST['text'], FILTER_SANITIZE_STRING);
      }

      if (empty($_FILES['images']['name'][0]))
      {
        $image = filter_var($_POST['stored_image'], FILTER_SANITIZE_STRING);
      } elseif (empty($_POST['stored_image']))
      {
        $image = filter_var($_FILES['images']['name'][0], FILTER_SANITIZE_STRING);
      }

      if (!$error)
      {
        if ((new ActionsModel())->check_user($_POST['author']))
        {
          $author_id = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
          $action = $_POST['action'][0];
          $section = $_POST['content'][0];
          $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
          $element_date = filter_var(substr(date("Y-m-d H:i:sa"), 0, -2), FILTER_SANITIZE_STRING);
          $image_dir = 'public/img/';
          $element_image = filter_var($image, FILTER_SANITIZE_STRING);
          move_uploaded_file($_FILES['images']['tmp_name'][0], $image_dir . $element_image);

          if ($action === 'edit')
          {
            $element_archived = filter_var($_POST['archive'][0], FILTER_SANITIZE_STRING);

            if ($section === 'articles')
            {
              (new ActionsModel())->update_article($element_title, $element_text, $element_image, $author_id, $element_archived, $element_id);
            }
            $action_msg .= 'element updated';
          } elseif ($action === 'archive')
          {
            $element_archived = 1;

            if ($section === 'articles')
            {
              (new ActionsModel())->archive_article($element_id, $element_title, $element_text, $element_image, $author_id, $element_archived);
            }
            $action_msg .= 'element archived';
          } elseif ($action === 'delete')
          {
            if ($section === 'articles')
            {
              (new ActionsModel())->delete_article($element_id);
            }
            $action_msg .= 'element deleted';
          }
          header('Location:/?result=' . urlencode($action_msg));
        } else
        {
          $error_msg .= "you are not allowed to $action content";
          echo "$error_msg<br>";
        }
      } else
      {
        $error_msg .= 'could not perform requested action';
        echo "$error_msg<br>";
      }
    }
  }
