<!-- onsubmit="AJAXSubmit(this); return false;" -->
<form id="ajax-form" class="hidden" name="editor-form" action="." method="POST" enctype="multipart/form-data">
  <fieldset class="ajax-form-container">
    <legend>Edit <?php echo $type; ?></legend>
    <select id="elementContent" class="" name="content[]">
      <option value="<?php echo $type . 's'; ?>"><?php echo $type; ?></option>
    </select>
  <?php
  if ($type !== 'about') {
    if ($element[$prefix . 'archived'])
    {
      ?>
      <select id="elementArchive" class="" name="archive[]">
        <option value="<?php echo $element[$prefix . 'archived']; ?>">archived</option>
        <option value=" <?php echo 0; ?>">unarchive</option>
      </select>
      <?php
    } else
    {
      ?>
      <select id="elementArchive" class="" name="archive[]">
        <option value="<?php echo $element[$prefix . 'archived']; ?>">unarchived</option>
        <option value="<?php echo 1; ?>">archive</option>
      </select>
      <?php
    }
  }
  ?>
  <input id="elementId" class="" type="number" name="id" value="<?php echo $element[$prefix . 'id']; ?>" placeholder="id: <?php echo $id; ?>">
  <input id="titleElement" class="" type="text" name="title" value="<?php echo $element[$prefix . 'title']; ?>" placeholder="title: <?php echo $element[$prefix . 'title']; ?>">
  <input id="elementAuthor" class="" type="text" name="author" value="<?php echo $element['author_id']; ?>" placeholder="author: <?php echo (new UserModel())->get_username($element['author_id']); ?>">
  <input type="hidden" name="stored_image" value="<?php echo $element[$prefix . 'image']; ?>">
  <input id="elementImage" class="" type="file" multiple name="images[]" value="<?php echo $element[$prefix . 'image']; ?>">
  <textarea id="elementText" class="" name="text" cols="50" rows="8" placeholder=""><?php echo $element[$prefix . 'text']; ?></textarea>
  <select id="elementAction" class="" name="action[]">
    <option>edit</option>
    <option>archive</option>
    <option>delete</option>
  </select>
  <button id="elementSubmit" class="" type="submit" name="edit">submit</button>
  </fieldset>
</form>
