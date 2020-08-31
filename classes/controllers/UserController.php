<?php

class UserController
{

  public static function sign_up()
  {
    $error = false;
    $username = $password = $error_msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-up']))
    {

      if (empty($_POST['username']))
      {
        $error = true;
        $error_msg .= 'username cannot be empty';
      } elseif (strlen($_POST['username']) < 6)
      {
        $error = true;
        $error_msg .= 'username must contain more than 6 characters';
      } else
      {
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['password']))
      {
        $error = true;
        $error_msg .= 'password cannot be empty';
      } elseif (strlen($_POST['password']) < 7)
      {
        $error = true;
        $error_msg .= 'password must contain more than 7 characters';
      } elseif(!preg_match("#[0-9]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= 'password must contain at least one number!';
      } elseif(!preg_match("#[a-z]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= 'password must contain at least one lowercase character!';
      } elseif(!preg_match("#[A-Z]+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= 'password must contain at least one uppercase character!';
      } elseif(!preg_match("#\W+#", $_POST['password']))
      {
        $error = true;
        $error_msg .= 'password must contain at least one symbol!';
      } elseif ($_POST['password'] !== $_POST['confirm-password'])
      {
        $error = true;
        $error_msg .= 'passwords do not match';
      } else
      {
        $options = [
          'cost' => 12,
        ];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
      }
      $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    }

    if ($error === true)
    {
      (new UserModel())->create_new_user($status, $username, $password);

      $_SESSION['user'] = $username;
      $_SESSION['status'] = $status;
      $_SESSION['logged_in'] = true;

      header('Location:/');
    } else
    {
      header("Location:/login&error=$error_msg");
    }
    require ABS_PATH . 'templates/loginView.php';
  }

  public static function sign_in()
  {
    $error = false;
    $username = $password = $error_msg = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['sign-in'])) {
      $username = $_POST['username'];
      $password = $_POST['password'];

      $user = (new UserModel())->get_user($username);

      if ($user === false)
      {
        $error = true;
        $error_msg .= 'user does not exist';
        header("Location:/login?error=$error_msg");
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

          header('Location:/');
        } else
        {
          $error_msg .= 'password incorrect';
          header("Location:/login?error=$error_msg");
        }
      }
    }
    require ABS_PATH . 'templates/loginView.php';
  }

  public static function sign_out()
  {
    if (isset($_GET['logout']) && ($_GET['logout'] == 'yes'))
    {
      session_unset();
      session_destroy();
      header('Location:/');
    }
  }

  public static function is_logged()
  {
    if (!isset($_SESSION['logged_in']) || ($_SESSION['logged_in'] !== true))
    {
      include ABS_PATH . 'include/logout_nav.php';
    } else
    {
      if ($_SESSION['status'] === 'admin')
      {
        include ABS_PATH . 'include/admin_login_nav.php';
      } elseif ($_SESSION['status'] === 'collaborator')
      {
        include ABS_PATH . 'include/collaborator_login_nav.php';
      }
    }
  }
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['sign-up']))
{
  UserController::sign_up();
} elseif (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['sign-in']))
{
  UserController::sign_in();
} elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['logout']))
{
  UserController::sign_out();
}
