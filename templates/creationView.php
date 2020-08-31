<!-- onsubmit="AJAXSubmit(this); return false;" -->
<form id="ajax-form" class="" action="." method="POST" enctype="multipart/form-data">
  <fieldset class="ajax-form-container">
    <legend>Create</legend>
    <select class="" name="content[]">
      <option value=""></option>
      <option value="articles">article</option>
      <option value="projects">project</option>
    </select>
    <input class="" type="number" name="id" value="" placeholder="element id: ">
    <input class="" type="text" name="title" value="" placeholder="element title:">
    <input class="" type="text" name="author" value="<?php echo (new UserModel())->get_user_id($_SESSION['user']); ?>">
    <input type="hidden" name="stored_image" value="">
    <input class="" type="file" multiple name="images[]" value="">
    <textarea class="" name="text" cols="50" rows="8" placeholder="element text"></textarea>
    <legend>choose action</legend>
    <select class="" name="action[]">
      <option>create</option>
      <option>edit</option>
      <option>archive</option>
      <option>delete</option>
    </select>
    <button id="elementSubmit" class="" type="submit" name="create">submit</button>
  </fieldset>
</form>
<p id="ajaxResponse"></p>
<script src="/public/js/ajax.js"></script>
