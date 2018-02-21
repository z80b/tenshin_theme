
<div class="lp-popup__overlay">
    <div class="lp-popup__wrapper">
        <div class="lp-popup">
            <div class="lp-popup__head"><?php print $title ?></div>
            <div class="lp-popup__body">
                <div class="lp-profile">
                    <?php print $messages; ?>
                    <?php if ($current_path == 'user' || $current_path == 'user/login'): ?>
                    <?php
                        $form = drupal_get_form('user_login');
                        print drupal_render($form);
                    ?>
                    <a class="lp-profile__link" href="/user/password"><?php print t('Request new password') ?></a>
                    <?php elseif ($current_path == 'user/password'): ?>
                    <?php
                        $form = drupal_get_form('user_pass');
                        print drupal_render($form);
                    ?>
                    <?php else: ?>
                    <?php print render($page['content']); ?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>