<?php
$title = 'about me!';
include '../include/header.php';
?>

<main class="main-container">

  <div class="article-container">
    <?php display_about(); ?>
    <div>
      <form id="ajax-form" class="hidden" action=" <?php echo ROOT_DIR . '/controllers/ajaxReceive.php'; ?> " method="post" enctype="multipart/form-data"
      onsubmit="ajaxSend(this); return false;">
        <fieldset class="ajax-form-container">
        <legend>project handler</legend>
        <label for="content_article">
          <input type="checkbox" name="content[]" value="about"/>about
        </label>
        <label for="content_article">
          <input type="checkbox" name="content[]" value="article"/>article
        </label>
        <label for="content_project">
          <input type="checkbox" name="content[]" value="project"/>project
        </label>
        <!--
        <select class="" name="element[]">
          <option>article</option>
          <option>project</option>
        </select>
        -->
        <input class="" type="number" name="id" value="" placeholder="element id">
        <input class="" type="text" name="title" value="" placeholder="element title">
        <input class="" type="number" name="author" value="" placeholder="author id">
        <input class="" type="file" multiple name="images[]" value="">
        <textarea class="" name="text" cols="50" rows="8" placeholder="element text"></textarea>
        <legend>choose action</legend>
        <select class="" name="action[]">
          <option></option>
          <option>create</option>
          <option>edit</option>
          <option>archive</option>
          <option>delete</option>
        </select>
        <input id="" class="" type="submit" name="submit" value="submit"/>
        </fieldset>
      </form>
    </div>
  </div>

</main>

<?php
include '../include/footer.php';

// load ajax or the corresponding script
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
  echo '<script src="public/js/someScript.js"></script>';
} else {
  echo '<script src="../public/js/ajax.js"></script>';
}
?>
