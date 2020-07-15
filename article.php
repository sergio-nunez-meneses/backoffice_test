<?php
$title = 'article';
include 'include/header.php';
?>

<main class="main-container">

  <div class="article-container">

    <?php article(); ?>

    <div>
      <form id="ajax-form" class="hidden" action="controllers/ajaxReceive.php" method="post" enctype="multipart/form-data"
      onsubmit="ajaxSend(this); return false;">
        <fieldset class="handler-container">
        <legend>project handler</legend>
        <input class="" type="text" name="id" value="" placeholder="article id" required>
        <input class="" type="text" name="title" value="" placeholder="article title" required>
        <input class="" type="text" name="author" value="" placeholder="author id" required>
        <input class="" type="file" multiple name="images[]" value="" required>
        <textarea id="content" class="" name="text" cols="50" rows="8" placeholder="article text"></textarea required>
        <legend>choose action</legend>
        <select class="" name="action[]" required>
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

<p id="ajaxResponse"></p>

<script src="public/js/ajax.js"></script>

<?php include 'include/footer.php'; ?>
