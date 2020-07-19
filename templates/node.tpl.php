<section class="lp-page__node lp-node">
    <h2 class="lp-node__title"><?php print $title ?></h2>
    <div class="lp-node__body">
    <?php if ($node_url == '/media'): ?>
        <?php include('node--media-photo.tpl.php') ?>
    <?php elseif ($node_url == '/media/video'): ?>
        <?php include('node--media-video.tpl.php') ?>
    <?php elseif ($node_url == '/faq'): ?>
        <?php include('node--faq.tpl.php') ?>
    <?php else: ?>
        <div class="lp-node__content">
            <?php print render($content) ?>
        </div>
        <?php if (isset($sub_menu)): ?>
            <div class="lp-node__submenu lp-submenu">
                <?php foreach ($sub_menu as $item): ?>
                <a  class="lp-submenu__item<?php if ($item->link_path == "node/$nid") print ' lp-submenu__item--active' ?>"
                <?php if ($node_url != '/'.$item->link_path): ?>href="<?php print url($item->link_path) ?>"<?php endif ?>>
                    <?php print $item->link_title ?>
                </a>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    <?php endif ?>
    </div>
    <div class="lp-node__footer"></div>
</section>