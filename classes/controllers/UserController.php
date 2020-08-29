<?php

class UserController extends Database
{

  public function sign_up()
  {
    $error = false;
    $username = $password = $error_msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up']))
    {

      if (empty($_POST['username']))
      {
        $error = true;
        $error_msg .= '<p>username cannot be empty</p>';
      } elseif (strlen($_POST['username']) < 6)
      {
        $error = true;
        $error_msg .= '<p>username must contain more than 6 characters</p>';
      } else
      {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['password']))
      {
        $error = true;
        $error_msg .= '<p>password cannot be empty</p>';
      } elseif (strlen($_POST['password']) < 7)
      {
        $error = true;
        $error_msg .= '<p>password must contain more than 7 characters</p>';
      } elseif(!preg_match("#[0-9]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= '<p>password must contain at least one number!</p>';
      } elseif(!preg_match("#[a-z]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= '<p>password must contain at least one lowercase character!</p>';
      } elseif(!preg_match("#[A-Z]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= '<p>password must contain at least one uppercase character!</p>';
      } elseif(!preg_match("#\W+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= '<p>password must contain at least one symbol!</p>';
      } elseif ($_POST['password'] !== $_POST['confirm-password'])
      {
        $error = true;
        $error_msg .= '<p>passwords do not match</p>';
      } else
      {
        $options = [
          'cost' => 12,
        ];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
      }
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    }

    if (!$error)
    {
      (new UserModel())->create_new_user($status, $username, $password);

      $_SESSION['user'] = $username;
      $_SESSION['status'] = $status;
      $_SESSION['logged_in'] = true;

      header('Location:index.php');
    } else
    {
      header("Location:index.php?page=login&error=$error_msg");
    }
  }

  public function sign_in()
  {
    $error = false;
    $username = $password = $error_msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-in'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $user = (new UserModel())->get_user($username);

      if ($user == false)
      {
        $error = true;
        $error_msg .= '<p>user does not exist</p>';
        header("Location:index.php?page=login&error=$error_msg");
      } else
      {
        $username = $user['author_username'];
        $stored_password = $user['author_password'];
        $status = $user['author_status'];

        if (password_verify($password, $stored_password) && $error !== true)
        {
          $_SESSION['user'] = $username;
          $_SESSION['status'] = $status;
          $_SESSION['logged_in'] = true;

          header('Location:index.php');
          // ob_end_flush();
        } else
        {
          $error_msg .= '<p>password incorrect</p>';
          header("Location:index.php?page=login&error=$error_msg");
        }
      }
    }
  }

  public function sign_out()
  {
    if ($_GET['logout'] == 'yes')
    {
      session_unset();
      session_destroy();
      header('Location:index.php');
    }
  }

  public function is_logged()
  {
    if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] !== true))
    {
      include ABS_PATH . '/include/logout_nav.php';
    } else
    {
      if ($_SESSION['status'] === 'admin')
      {
        include ABS_PATH . '/include/admin_login_nav.php';
      } elseif ($_SESSION['status'] === 'collaborator')
      {
        include ABS_PATH . '/include/collaborator_login_nav.php';
      }
    }
  }
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['sign-up']))
{
  (new UserController())->sign_up();
} elseif (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['sign-in']))
{
  (new UserController())->sign_in();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout']) && ($_GET['logout'] === 'yes'))
{
  (new UserController())->sign_out();
}
