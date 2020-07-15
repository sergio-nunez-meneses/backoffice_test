<?php
$title = 'article';
include 'include/header.php';
?>

<main class="main-container">

  <div class="article-container">

    <?php article(); ?>

    <div>
      <form id="ajax-form" class="hidden" action="controllers/ajax.php" method="post" enctype="multipart/form-data"
      onsubmit="ajaxSubmit(this); return false;">
        <fieldset class="handler-container">
        <legend>project handler</legend>
        <input class="" type="text" name="id" value="" placeholder="article id">
        <input class="" type="text" name="title" value="" placeholder="article title">
        <input class="" type="text" name="author" value="" placeholder="author id">
        <input class="" type="file" multiple name="images[]" value="">
        <textarea id="content" class="" name="text" cols="50" rows="8" placeholder="article text"></textarea>
        <legend>choose action</legend>
        <select class="" name="action[]">
          <option></option>
          <option>create</option>
          <option>edit</option>
          <option>archive</option>
          <option>delete</option>
        </select>
        <input id="" class="" type="submit" value="submit"/>
        </fieldset>
      </form>
    </div>
  </div>

</main>

<p id="displayInfo"></p>

<script src="public/js/ajax.js"></script>

<?php include 'include/footer.php'; ?>
