<?php if ($pages_count > 1): ?>
<div class="x-paginator">
  <?php if (1 == $current_page): ?>
    <a class="x-paginator__prev x-paginator__prev--disabled"></a>
  <?php else: ?>
  <a
    class="x-paginator__prev"
    href="?page=<?= $current_page - 1 ?>"></a>
  <?php endif ?>
  <?php for ($index = 1; $index <= $pages_count; $index++): ?>
    <?= l($index, $node_url, array(
      'query' => array_merge(drupal_get_query_parameters(), array('page' => $index)),
      'attributes' => array(
        'class' => 'x-paginator__button' . ($index == $current_page ? ' x-paginator__button--active' : ''),
      ),
    )) ?>
  <?php endfor ?>
  <?php if ($pages_count == $current_page): ?>
    <a class="x-paginator__next x-paginator__next--disabled"></a>
  <?php else: ?>
  <a
    class="x-paginator__next"
    href="?page=<?= $current_page + 1 ?>"></a>
  <?php endif ?>
</div>
<?php endif ?>