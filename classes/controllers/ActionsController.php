<?php

class ActionsController extends Database
{

  public function create_element()
  {
      // $form = 'ajax-element-form';
      $error = false;
      $author_id = $element_id = $element_type = $element_title = $element_text = $action = $action_msg = $error_msg = '';

      date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= '<p>sign in to create an element</p>';
    } else
    {
      if (empty($_POST['title']))
      {
        $error = true;
        $error_msg .= '<p>title cannot be empty</p>';
      } elseif (strlen($_POST['title']) < 5)
      {
        $error = true;
        $error_msg .= '<p>title must contain more than 5 characters</p>';
      } else
      {
        $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['text']))
      {
        $error = true;
        $error_msg .= '<p>text cannot be empty</p>';
      } elseif (strlen($_POST['text']) < 10){
        $error = true;
        $error_msg .= '<p>text must contain more than 10 characters</p>';
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
            $action_msg .= '<p>element created</p>';
            header('Location:index.php?page=create&result=' . urlencode($action_msg));
            // echo $action_msg;
          }
        } else
        {
          $error_msg .= "<p>you are not allowed to $action content</p>";
          header('Location:index.php?page=create&result=' . urlencode($error_msg));
        }
      } else
      {
        $error_msg .= '<p>could not perform requested action</p>';
        header('Location:index.php?page=create&result=' . urlencode($error_msg));
        // echo "$error_msg<br>";
      }
    }
  }

  public function update_element()
  {
    // $form = 'ajax-element-form';
    $error = false;
    $author_id = $element_id = $element_type = $element_title = $element_text = $action = $action_msg = $error_msg = '';

    date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= '<p>sign in to edit this element</p>';
    } else
    {
      if (empty($_POST['title']))
      {
        $error = true;
        $error_msg .= '<p>title cannot be empty</p>';
      } elseif (strlen($_POST['title']) < 5)
      {
        $error = true;
        $error_msg .= '<p>title must contain more than 5 characters</p>';
      } else
      {
        $element_title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['text']))
      {
        $error = true;
        $error_msg .= '<p>text cannot be empty</p>';
      } elseif (strlen($_POST['text']) < 10){
        $error = true;
        $error_msg .= '<p>text must contain more than 10 characters</p>';
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
            $action_msg .= '<p>element updated</p>';
            echo $action_msg;
          }
        } else
        {
          $error_msg .= "<p>you are not allowed to $action content</p>";
          echo "$error_msg<br>";
        }
      } else
      {
        $error_msg .= '<p>could not perform requested action</p>';
        echo "$error_msg<br>";
      }
    }
  }

  public function delete_element()
  {
    // $form = 'ajax-element-form';
    $error = false;
    $author_id = $element_id = $action = $action_msg = $section = $error_msg = '';

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= '<p>sign in to delete this element</p>';
    } else
    {
      if (!$error)
      {
        if ((new ActionsModel())->check_user($_POST['author']))
        {
          $author_id = filter_var($_POST['author'], FILTER_SANITIZE_STRING);
          $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);;
          $action = $_POST['action'][0];
          $section = $_POST['content'][0];

          if ($action === 'delete')
          {
            if ($section === 'articles')
            {
              (new ActionsModel())->delete_article($element_id);
            }
            $action_msg .= '<p>element deleted</p>';
            echo $action_msg;
          }
        } else
        {
          $error_msg .= "<p>you are not allowed to $action content</p>";
          echo "$error_msg<br>";
        }
      } else
      {
        $error_msg .= '<p>could not perform requested action</p>';
        echo "$error_msg<br>";
      }
    }
  }
}
