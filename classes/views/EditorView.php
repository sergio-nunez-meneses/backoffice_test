<?php

class EditorView extends Database
{

  public function edition_view($element)
  {
    $id = $type = $prefix = '';

    if (($_SERVER['REQUEST_METHOD'] == 'GET') && isset($_GET['id']) && isset($_GET['element']))
    {
      $id = $_GET['id'];
      $type = $_GET['element'];
      $prefix = $type . '_';
    }
    ?>
    <!-- onsubmit="ajaxSend(this); return false;" -->
    <form id="ajax-form" class="hidden" name="editor-form" action="../controllers/content_editor_receiver.php" method="POST" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
        <legend>Edit <?php echo $type; ?></legend>
        <select id="elementContent" class="" name="content[]">
          <option value="<?php echo $type; ?>"><?php echo $type; ?></option>
        </select>
      <?php
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
      ?>
      <input id="elementId" class="" type="number" name="id" value="<?php echo $element[$prefix . 'id']; ?>" placeholder="id: <?php echo $id; ?>">
      <input id="titleElement" class="" type="text" name="title" value="<?php echo $element[$prefix . 'title']; ?>" placeholder="title: <?php echo $element[$prefix . 'title']; ?>">
      <input id="elementAuthor" class="" type="text" name="author[]" value="<?php echo $element['author_id']; ?>" placeholder="author: <?php echo (new UserModel())->get_username($element['author_id']); ?>">
      <input id="elementImage" class="" type="file" multiple name="images[]" value="<?php echo $element[$prefix . 'image']; ?>">
      <textarea id="elementText" class="" name="text" cols="50" rows="8" placeholder=""><?php echo $element[$prefix . 'text']; ?></textarea>
      <select id="elementAction" class="" name="action[]">
        <option></option>
        <option>create</option>
        <option>edit</option>
        <option>archive</option>
        <option>delete</option>
      </select>
      <button id="elementSubmit" class="" type="submit" name="button">submit</button>
      </fieldset>
    </form>
    <?php
  }

  public function creation_view()
  {
    ?>
    <form id="ajax-form" class="" action="../controllers/content_editor_receiver.php" method="POST" enctype="multipart/form-data" onsubmit="ajaxSend(this); return false;">
      <fieldset class="ajax-form-container">
        <legend>Create</legend>
        <select class="" name="content[]">
          <option value=""></option>
          <option value="articles">article</option>
          <option value="projects">project</option>
        </select>
        <input class="" type="number" name="id" value="" placeholder="element id: ">
        <input class="" type="text" name="title" value="" placeholder="element title:">
        <input class="" type="text" name="author" value="
        <?php
        $user_id = (new UserModel())->get_user_id($_SESSION['user']);
        echo $user_id;
        ?>
        " placeholder="author: <?php echo (new UserModel())->get_username($user_id); ?>">
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
        <button id="elementSubmit" class="" type="submit" name="button">submit</button>
      </fieldset>
    </form>
    <?php
  }
}
