<div class="lp-node__content lp-faq">
  <div class="lp-faq__content">
    <?php foreach ($faq as $index => $item): ?>
    <input id="faq-item-<?= $index?>" class="lp-faq__switch" type="checkbox"/>
    <div class="lp-faq__item">
      <label class="lp-faq__title" for="faq-item-<?= $index?>">
        <?= $item->title ?></label>
      <div class="lp-faq__body"><?= $item->body ?></div>
    </div>
    <?php endforeach ?>
  </div>
</div>