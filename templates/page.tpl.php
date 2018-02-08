<div class="lp-page<?php print drupal_is_front_page() ? ' lp-page--front' : '' ?> js-lp-page">
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
        <?php if ($is_front): ?>
            <?php if ($slider_images): ?>
            <div class="lp-header__slider lp-slider js-head-slider">
                <div class="lp-slider__body">
                <?php foreach ($slider_images as $index => $uri): ?>
                    <img class="lp-header__slide" src="<?php print file_create_url($uri) ?>" style="z-index: <?php print -$index ?>">
                <?php endforeach ?>
                </div>
                <div class="lp-slider__wrapper">
                    <div class="lp-slider__controls lp-controls">
                        <button class="lp-slider__button-prev"></button>
                        <button class="lp-slider__button">1</button>
                        <button class="lp-slider__button">2</button>
                        <button class="lp-slider__button">3</button>
                        <button class="lp-slider__button">4</button>
                        <button class="lp-slider__button">5</button>
                        <button class="lp-slider__button">6</button>
                        <button class="lp-slider__button">7</button>
                        <button class="lp-slider__button">8</button>
                        <button class="lp-slider__button-next"></button>
                    </div>
                </div>
            </div>
            <?php endif ?>
            <?php if ($header_teasers): ?>
            <div class="lp-header__teasers">
                <?php foreach ($header_teasers as $teaser): ?>
                <div class="lp-header-teaser">
                    <h2 class="lp-header-teaser__title"><?php print $teaser->title ?></h2>
                    <span class="lp-header-teaser__text"><?php print strip_tags($teaser->body_summary) ?></span>
                    <?php print l('Узнать больше', 'node/'. $teaser->nid, array('attributes' => array('class' => 'lp-header-teaser__button')))?>
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
    <section class="lp-videos">
        <div class="lp-videos__inner">
            <button class="lp-videos__button lp-videos__button--left"></button>
            <button class="lp-videos__button lp-videos__button--right"></button>
            <div class="lp-videos__slider js-video-slider">
                <?php foreach($video_teasers as $teaser): ?>
                <a  class="lp-videos__slide js-video-link"
                    href="<?php print $teaser->video ?>"
                    title="<?php print $teaser->title ?>"
                    data-embed-url="<?php print $teaser->embed_url ?>">
                        <span class="lp-videos__image-wrapper">
                            <span class="lp-videos__image" style="background-image: url('<?php print file_create_url($teaser->thumbnail) ?>')"></span>
                        </span>
                    </a>
                <?php endforeach ?>
            </div>
        </div>
    </section>
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
<div class="lp-popup__overlay js-popup lp-popup--hidden" style="display: none">
    <div class="lp-popup__wrapper">
        <div class="lp-popup">
            <div class="lp-popup__head">Храм Катори</div>
            <div class="lp-popup__body"></div>
        </div>
    </div>
</div>