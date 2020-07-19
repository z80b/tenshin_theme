<div class="lp-node__content lp-media">
  <div class="lp-media__controls">
    <a
      class="lp-media__button"
      href="/media">Фото</a>
    <a class="lp-media__button lp-media__button--active">Видео</a>
  </div>
  <div class="lp-media__content">
    <?php foreach ($videos as $video): ?>
    <a
      class="lp-videos__slide js-video-link"
      href="<?= $video->video ?>"
      title="<?= $video->title ?>"
      data-embed-url="<?= Media::videoUrl($video->video) ?>">
      <span class="lp-videos__image-wrapper">
        <span
          class="lp-videos__image"
          style="background-image: url('<?= Media::videoThumb($video->video) ?>')"></span>
      </span>
    </a>
    <?php endforeach ?>
  </div>
  <div class="lp-media__footer">
    <?php include('paginator.tpl.php') ?>
  </div>
</div>