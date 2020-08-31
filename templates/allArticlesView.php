<section class="element-box">
  <img class="element-image" src="/public/img/<?php echo $row[$prefix . 'image']; ?>">
  <div class="transparent-box">
    <article class="element-caption">
      <header>
        <h3>
          <a class="element-title" href="/element?element=<?php echo $type; ?>&id=<?php echo $row[$prefix . 'id']; ?>">
            <?php echo $row[$prefix . 'title']; ?>
          </a>
        </h3>
        <div class="">
          <p class="element-date">On <?php echo $formatted_date; ?></p>
          <p class="element-author">By <?php echo (new UserModel())->get_username($row['author_id']); ?></p>
        </div>
      </header>
      <main>
        <p><?php echo $shorten_text; ?></p>
        <a class="opacity-low" href="/element?element=<?php echo $type; ?>&id=<?php echo $row[$prefix . 'id']; ?>">
          continue reading
        </a>
      </main>
    </article>
  </div>
</section>
