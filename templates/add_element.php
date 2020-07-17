<?php
$title = 'add an article or a project';
include '../include/header.php';
?>

<main class="main-container">

  <div class="new-element">

  </div>

  <div>
    <form id="" class="" action="../controllers/ajaxReceive.php" method="post" enctype="multipart/form-data"
    onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
      <legend>create an element</legend>
      <label for="content_article">
        <input type="checkbox" name="content[]" value="article"/>article
      </label>
      <label for="content_project">
        <input type="checkbox" name="content[]" value="project"/>project
      </label>
      <select class="" name="element[]">
        <option>article</option>
        <option>project</option>
      </select>
      <input class="" type="text" name="id" value="" placeholder="element id">
      <input class="" type="text" name="title" value="" placeholder="element title">
      <input class="" type="text" name="author" value="" placeholder="author id">
      <input class="" type="file" multiple name="images[]" value="">
      <textarea class="" name="text" cols="50" rows="8" placeholder="element text"></textarea>
      <legend>choose action</legend>
      <select class="" name="action[]">
        <option></option>
        <option>create</option>
      </select>
      <input id="" class="" type="submit" name="submit" value="submit"/>
      </fieldset>
    </form>
  </div>

</main>

<p id="ajaxResponse" class="info"></p>

<?php include '../include/footer.php'; ?>

<script src="../public/js/ajax.js"></script>
