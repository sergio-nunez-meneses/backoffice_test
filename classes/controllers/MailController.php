<?php

class MailController
{

  public static function send_mail()
  {
    // $form = 'ajax-mail-form';
    $error = false;
    $info = $error_msg = '';

    if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['send-message']))
    {
      if (empty($_POST['firstname']))
      {
        $error = true;
        $error_msg .= 'firstname cannot be empty';
      } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['firstname']))
      {
        $error = true;
        $error_msg .= 'invalid firstname format';
      } else {
        $username = filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['lastname']))
      {
        $error = true;
        $error_msg .= 'lastname cannot be empty';
      } elseif (!preg_match('/^[a-z]{2,20}$/i', $_POST['lastname']))
      {
        $error = true;
        $error_msg .= 'invalid lastname format';
      } else
      {
        $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
      }

      if (empty($_POST['email']))
      {
        $error = true;
        $error_msg .= 'email cannot be empty';
      } elseif (!preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i', $_POST['email']))
      {
        $error = true;
        $error_msg .= 'invalid email format';
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
          $info .= 'mail sucessfully sent!';
          header('Location:/contact?mail=' . urlencode($info));
        }
      } else
      {
        $error_msg .= 'failed to send email!';
        header('Location:/contact?mail=' . urlencode($error_msg));
      }
    }
    require ABS_PATH . 'templates/mailView.php';
  }
}
