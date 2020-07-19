<div class="lp-node__content lp-media">
  <div class="lp-media__controls">
    <a
      class="lp-media__button lp-media__button--active"
      <?php if (isset($images)): ?>href="/media"<?php endif ?>>Фото</a>
    <a
      class="lp-media__button"
      href="/media/video">Видео</a>
  </div>
  <?php if (isset($images)): ?>
    <h2 class="lp-media__group-title"><?= $group_title ?></h2>
    <div class="lp-media__content">
      <?php foreach ($images as $image): ?>
      <a class="lp-media__item" href="<?= file_create_url($image->uri) ?>">
        <img class="lp-media__image" src="<?= image_style_url('thumb', $image->uri) ?>"/>
        <h2 class="lp-media__title"><?= $image->title ?></h2>
      </a>
      <?php endforeach ?>
    </div>
    <div class="lp-media__footer">
      <?php include('paginator.tpl.php') ?>
    </div>
  <?php else: ?>
    <?php foreach ($terms as $term): ?>
      <a href="?group=<?= $term->tid ?>"><?= $term->name ?></a>
    <?php endforeach ?>
  <?php endif ?>
</div>