<?php

class ActionsController extends Database
{

  public function create_element()
  {
    // $form = 'ajax-element-form';
    $error = false;
    $user_id = $element_type = $element_title = $element_text = $action = $action_msg = $error_msg = '';

    date_default_timezone_set('Europe/Paris');

    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
      $error = true;
      $error_msg .= '<p>sign in to edit this article</p>';
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
        $image = $_POST['stored_image'];
      } elseif (empty($_POST['stored_image']))
      {
        $image = $_FILES['images']['name'][0];
      }

      if (!$error)
      {
        $element_type = $_POST['content'][0];
        $element_id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $element_date = filter_var(substr(date("Y-m-d H:i:sa"), 0, -2), FILTER_SANITIZE_STRING);

        $image_dir = 'public/img/';
        $element_image = filter_var($image, FILTER_SANITIZE_STRING);
        move_uploaded_file($_FILES['images']['tmp_name'][0], $image_dir . $element_image);

        if ((new ActionsModel())->check_user($_POST['author']))
        {
          $author_id = $_POST['author'];
          $action = $_POST['action'][0];
          $section = $_POST['content'][0];
          if ($action === 'create')
          {
            $element_archived = 0;

            if ($section === 'articles')
            {
              (new ActionsModel())->create_article($element_title, $element_text, $element_image, $author_id, $element_archived);
            }
            $action_msg .= '<p>element created</p>';
            echo "$action_msg<br>";
          }
        }
      } else {
        $error_msg .= '<p>could not perform requested action</p>';
        echo "$error_msg<br>";
      }
    }
  }
}
