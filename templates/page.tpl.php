<div class="lp-page">
    <section class="lp-page__header lp-header">
        <?php if ($main_menu): ?>
        <nav class="lp-header__menu lp-menu">
            <div class="lp-menu__inner">
                <a class="lp-menu__logo" href="/"></a>
                <?php foreach ($main_menu as $item): ?>
                <a class="lp-menu__button" href="<?php print $item->link_path ?>"><?php print $item->link_title ?></a>
                <?php endforeach ?>
                <a class="lp-menu__button" href="">ПУНКТ 1</a>
                <a class="lp-menu__button" href="">ПУНКТ 2</a>
                <a class="lp-menu__button" href="">ПУНКТ 3</a>
                <a class="lp-menu__button" href="">ПУНКТ 4</a>
                <a class="lp-menu__button" href="">ПУНКТ 5</a>
                <a class="lp-menu__button" href="">ПУНКТ 6</a>
                <a class="lp-menu__button" href="">ПУНКТ 7</a>
                <a class="lp-menu__button" href="">ПУНКТ 8</a>
            </div>
        </nav>
        <?php endif ?>
        <div class="lp-header__sharing lp-sharing">
            <a class="lp-sharing__button lp-sharing__button--tw" href="<?php print $tw_link ?>"></a>
            <a class="lp-sharing__button lp-sharing__button--fb" href="<?php print $bf_link ?>"></a>
        </div>
        <?php if ($slider_images): ?>
        <div class="lp-header__slider">
            <?php foreach ($slider_images as $uri): ?>
            <img src="<?php print file_create_url($uri) ?>">
            <?php endforeach ?>
        </div>
        <?php endif ?>
        <?php if ($header_teasers): ?>
        <div class="lp-header__teasers">
            <?php foreach ($header_teasers as $teaser): ?>
            <div class="lp-header-teaser">
                <h2 class="lp-header-teaser__title"><?php print $teaser->title ?></h2>
                <span class="lp-header-teaser__text"><?php print strip_tags($teaser->body_summary) ?></span>
                <a class="lp-header-teaser__button href="<?php print url('/node/'. $teaser->nid) ?>">Узнать больше</a>
            </div>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    </section>
</div>