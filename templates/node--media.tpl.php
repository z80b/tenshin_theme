<section class="lp-page__node lp-node">
    <h2 class="lp-node__title"><?php print $title ?></h2>
    <div class="lp-node__body">
        <div class="lp-node__content lp-media">
            <div class="lp-media__controls">
                <a class="lp-media__button"<?php if ($path != 'media/photo'): ?> href="/media/photo"<?php endif ?>>Фото</a>
                <a class="lp-media__button"<?php if ($path != 'media/video'): ?> href="/media/video"<?php endif ?>>Видео</a>
            </div>
        </div>
    </div>
    <div class="lp-node__footer"></div>
</section>