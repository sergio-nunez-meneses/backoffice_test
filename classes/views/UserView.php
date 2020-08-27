<?php

class UserView extends Database
{
  public function login_view()
  {
    if (isset($_GET['error']) && ($_GET['error'] === 'yes'))
    {
      echo $_GET['error_me'];
    }
    ?>
    <div class="login-container">
      <button id="sign-in-tab" class="">Sign in</button>
      <!-- SIGN IN -->
      <form id="sign-in-form" class="" method="post" action="login.php">
        <fieldset class="sign-in-container">
        <legend>Sign in</legend>
        <input class="" type="text" name="username" value="" placeholder="username" required>
        <input class="" type="password" name="password" value="" placeholder="password" required>
        <input class="" type="submit" name="sign-in" value="sign in">
        </fieldset>
      </form>
      <!-- SIGN UP -->
      <form id="sign-up-form" class="hidden" method="post" action="../controllers/validate.php">
        <fieldset class="sign-up-container">
        <legend>Sign up</legend>
        <input class="" type="text" name="username" placeholder="username" required>
        <select class="" name="status" required>
          <option value="admin">Admin</option>
          <option value="collaborator">Collaborator</option>
        </select>
        <input type="password" class="" name="password" placeholder="password" required>
        <input type="password" class="" name="confirm-password" placeholder="confirm password" required>
        <input class="" type="submit" name="sign-up" value="sign up">
        </fieldset>
      </form>
    </div>
    <?php
  }
}

(new UserView())->login_view();
