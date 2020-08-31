<?php
require ABS_PATH . 'templates/mailView.php';

class MailController
{

  public static function send_mail()
  {
    $form = 'ajax-mail-form';
    $error = false;
    $info = $error_msg = '';

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['send-message']))
    {
      if (empty($_POST['firstname']))
      {
        $error = true;
        $error_msg .= '<p>firstname cannot be empty</p>';
      } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['firstname']))
      {
        $error = true;
        $error_msg .= '<p>invalid firstname format</p>';
      } else {
        $username = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['lastname']))
      {
        $error = true;
        $error_msg .= '<p>lastname cannot be empty</p>';
      } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['lastname']))
      {
        $error = true;
        $error_msg .= '<p>invalid lastname format</p>';
      } else
      {
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['email']))
      {
        $error = true;
        $error_msg .= '<p>email cannot be empty</p>';
      } elseif (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $_POST['email']))
      {
        $error = true;
        $error_msg .= '<p>invalid email format</p>';
      } else
      {
        $from = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      }

      if ($error === false)
      {
        $to = 'To: s.nunezmeneses@codeur.online';
        $subject = "New message from $username $lastname";
        $message = $_POST['message'];
        $headers = "From: $from";

        if (mail($to, $subject, $message, $headers))
        {
          $info .= '<p>mail sucessfully sent!</p>';
          header('Location:/contact?mail=' . urlencode($info));
        }
      } else
      {
        $error_msg .= '<p>failed to send email!</p>';
        header('Location:/contact?mail=' . urlencode($error_msg));
      }
    }
  }
}

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['send-message']))
{
  MailController::send_mail();
}
