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

function main_menu() {
    return $query = db_select('menu_links', 'm')
        ->fields('m', array('link_path', 'link_title'))
        ->orderBy('m.weight', 'ASC')
        ->condition('m.menu_name', 'main-menu', '=')
        ->condition('m.plid', '0', '=')
        ->condition('m.hidden', '0', '=')
        ->execute()
        ->fetchAll();
}

function tenshin_theme_process_page(&$variables) {
    $variables['slider_images'] = slider_images();
    $variables['header_teasers'] = header_teasers();
    $variables['main_menu'] = main_menu();

    // Social links
    $variables['tw_link'] = theme_get_setting('tw_link', 'tenshin_theme');
    $variables['fb_link'] = theme_get_setting('fb_link', 'tenshin_theme');

    // Footer texts
    $variables['footer_text_1'] = theme_get_setting('footer_text_1', 'tenshin_theme');
    $variables['footer_text_2'] = theme_get_setting('footer_text_1', 'tenshin_theme');
}