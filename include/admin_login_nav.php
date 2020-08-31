<a href="/user?username=<?php echo $_SESSION['user']; ?>" class="">
  <i class="fa fa-user-circle-o" aria-hidden="true"></i>
  <span class="nav-item"> <?php echo $_SESSION['user']; ?> </span>
</a>
<a href="/create" class="">
  <i class="fa fa-plus-circle" aria-hidden="true"></i>
  <span class="nav-item">create</span>
</a>
<a href="/?logout=yes" class="">
  <i class="fa fa-sign-out" aria-hidden="true"></i>
  <span class="nav-item">logout</span>
</a>
