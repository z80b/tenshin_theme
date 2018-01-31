<div class="lp-page<?php print drupal_is_front_page() ? ' lp-page--front' : '' ?>">
    <section class="lp-page__header lp-header">
        <?php if ($main_menu): ?>
        <nav class="lp-header__menu lp-menu">
            <div class="lp-menu__inner">
                <a class="lp-menu__logo" href="/"></a>
                <div class="lp-menu__buttons">
                    <?php foreach ($main_menu as $item): ?>
                    <a class="lp-menu__button" href="<?php print url($item->link_path) ?>"><?php print $item->link_title ?></a>
                    <?php endforeach ?>
                </div>
            </div>
        </nav>
        <?php endif ?>
        <div class="lp-header__sharing lp-sharing">
            <a class="lp-sharing__button lp-sharing__button--tw" href="<?php print $tw_link ?>"></a>
            <a class="lp-sharing__button lp-sharing__button--fb" href="<?php print $fb_link ?>"></a>
        </div>
        <?php if (drupal_is_front_page()): ?>
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
        <?php endif ?>
    </section>
    <section class="lp-page__content">
        <?php if (!$is_front): ?>
        <?php print render($page['content']); ?>
        <?php endif ?>
    </section>
    <?php if ($is_front): ?>
    <section class="lp-bottom">
        <div class="lp-bottom__info lp-info">
            <div class="lp-info__left-side"><?php print $footer_text_1 ?></div>
            <div class="lp-info__right-side"><?php print $footer_text_2 ?></div>
        </div>
    </section>
    <?php endif ?>
    <section class="lp-footer">
        <div class="lp-footer__inner">
            <img class="lp-footer__logo" src="<?php print $logo ?>"/>
            <span class="lp-footer__copyright"><?php print $site_slogan ?></span>
            <span class="lp-footer__socials"></span>
        </div>
    </section>
</div>