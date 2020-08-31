<div class="contact-container">
  <button id="mail-tab">recover password</button>
  <!-- contact -->
  <form id="ajax-mail-form" class="" action="/contact" method="POST" enctype="multipart/form-data">
    <fieldset class="ajax-form-container">
      <legend>send message</legend>
      <input class="" type="text" name="firstname" placeholder="firstname" required>
      <input class="" type="text" name="lastname" placeholder="lastname" required>
      <input class="" type="text" name="email" placeholder="email" required>
      <textarea class="" name="message" cols="50" rows="8" placeholder="write me something..."></textarea>
      <button id="" class="" type="submit" name="send-message">send</button>
    </fieldset>
  </form>
  <!-- recover password -->
  <form id="ajax-recover-form" class="hidden" action="/contact" method="POST" enctype="multipart/form-data">
    <fieldset class="ajax-form-container">
      <legend>recover password</legend>
      <input class="" type="number" name="id" placeholder="id" required>
      <input class="" type="text" name="firstname" placeholder="firstname" required>
      <input class="" type="text" name="email" placeholder="email" required>
      <input id="" class="" type="submit" name="recover-password" value="send">
    </fieldset>
  </form>
</div>
<script src="public/js/ajax.js"></script>
