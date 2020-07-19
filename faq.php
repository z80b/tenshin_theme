<?php

class Faq {
  static function init(&$variables) {
    if ($variables['node_url'] == '/faq') {
      $variables['faq'] = self::getNodes();
    }
  }

  static function getNodes() {
    $query = db_select('node', 'n');
    $query->join('field_revision_body', 'f', 'n.nid = f.entity_id');
    $query->addField('n', 'title');
    $query->addField('f', 'body_value', 'body');
    return $query->orderBy('n.title')
      ->condition('n.type', 'faq', '=')
      ->condition('n.status', '1', '=')
      ->execute()
      ->fetchAll();
  }
}