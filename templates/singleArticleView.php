<?php
if (isset($_SESSION['logged_in']) && ($_SESSION['logged_in'] == true) && ($_SESSION['status'] === 'admin'))
{
  ?>
  <button id="handler-tab">edit</button>
  <?php
}
?>
<div class="article-container">
  <div id="element-<?php echo $element[$prefix . 'id']; ?>" class="focus-element-container">
    <section class="focus-element-header">
      <img id="image-<?php echo $element[$prefix . 'id']; ?>" class="focus-element-image" src="public/img/<?php echo $element[$prefix . 'image']; ?>">
    </section>
    <div class="focus-content-container">
      <h2 id="title-<?php echo $element[$prefix . 'id']; ?>" class="focus-element-title"><?php echo $element[$prefix . 'title']; ?></h2>
      <p id="date-<?php echo $element[$prefix . 'id']; ?>" class="focus-element-date">On <?php echo $formatted_date; ?></p>
      <p class="focus-element-username">By <?php echo (new UserModel())->get_username($element['author_id']); ?></p>
      <article id="text-<?php echo $element[$prefix . 'id']; ?>" class="focus-element-text"><?php echo $formatted_text; ?></article>
    </div>
  </div>
  <div class="">
    <?php EditorController::edit_content(); ?>
    <p id="ajaxResponse" class="info"></p>
  </div>
</div>
<script src="public/js/ajax.js"></script>
