<?php
$title = 'login';
include 'include/header.php';

// if ($_GET['error'] == '') echo '';
?>

<main class="main-container">

  <div class="login-container">
    <button id="sign-in-tab" class="">sign in</button>
    <!-- sign in -->
    <form id="sign-in-form" class="" method="post" action="login.php">
      <fieldset class="sign-in-container">
      <legend>sign in</legend>
      <!-- autofocus -->
      <input class="" type="text" name="username" value="" placeholder="username" required>
      <input class="" type="password" name="password" value="" placeholder="password" required>
      <input class="" type="submit" name="sign-in" value="sign in">
      </fieldset>
    </form>
    <!-- sign up -->
    <form id="sign-up-form" class="hidden" method="post" action="controllers/validate.php">
      <fieldset class="sign-up-container">
      <legend>sign up</legend>
      <input class="" type="text" name="username" placeholder="username" required>
      <select class="" name="status" required>
        <option value="admin">admin</option>
        <option value="collaborator">collaborator</option>
      </select>
      <input type="password" class="" name="password" placeholder="password" required>
      <input type="password" class="" name="confirm-password" placeholder="confirm password" required>
      <input class="" type="submit" name="sign-up" value="sign up">
      </fieldset>
    </form>
  </div>

</main>

<?php
echo '<p class="info">' . login() . '</p>';
include 'include/footer.php';
?>

<script src="public/js/login.js"></script>
