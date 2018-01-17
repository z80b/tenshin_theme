<?php

function slider_images() {
    $query = db_select('node', 'n');
    $query->join('field_data_field_image', 'i', 'n.nid = i.entity_id');
    $query->join('file_managed', 'f', 'f.fid = i.field_image_fid');
    return $query->fields('f', array('uri'))
        ->orderBy('n.title')
        ->condition('n.type', 'banner', '=')
        ->condition('n.status', '1', '=')
        ->condition('n.promote', '1', '=')
        ->execute()
        ->fetchCol();
}

function header_teasers() {
$query = db_select('node', 'n');
    $query->join('field_data_body', 'f', 'f.entity_id = n.nid');
    return $query
        ->fields('n', array('nid', 'title'))
        ->fields('f', array('body_summary'))
        ->orderBy('n.changed', 'DESC')
        ->condition('n.type', 'page', '=')
        ->condition('n.status', '1', '=')
        ->condition('n.promote', '1', '=')
        ->execute()
        ->fetchAll();
}

function tenshin_theme_process_page(&$variables) {
    $variables['slider_images'] = slider_images();
    $variables['header_teasers'] = header_teasers();
}