  </main>

  <footer class="footer-container">

    <div class="icons-container">
      <a href="https://github.com/sergio-nunez-meneses" class="">
        <i class="icon-item fa fa-github" aria-hidden="true"></i>
        <span class="icon-text">github</span>
      </a>
      <a href="#" class="">
        <i class="icon-item fa fa-gitlab" aria-hidden="true"></i>
        <span class="icon-text">gitlab</span>
      </a>
      <a href="#" class="">
        <i class="icon-item fa fa-soundcloud" aria-hidden="true"></i>
        <span class="icon-text">soundcloud</span>
      </a>
      <a href="#" class="">
        <i class="icon-item fa fa-vimeo" aria-hidden="true"></i>
        <span class="icon-text">vimeo</span>
      </a>
    </div>
    <div class="footer-text">
      <small class="">Site developed by Sergio Nuñez Meneses 2020</small>
    </div>
  </footer>

  <?php
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    ?>
    <script src="public/js/autoLogout.js"></script>
    <?php
  }
  ?>
  </body>
</html>
