<nav class="">

  <span class="">welcome, </span><a href=" <?php echo ROOT_DIR . '/templates/user.php'; ?> " class="">
    <span class=""> <?php echo $_SESSION['user']; ?> </span>
  </a>
  <a href=" <?php echo ROOT_DIR . '/templates/add_element.php'; ?> " class="">
    <span class="">add</span>
  </a>
  <a href=" <?php echo ROOT_DIR . '/logout.php?logout=yes'; ?> " class="">
    <span class="">logout</span>
  </a>

</nav>
