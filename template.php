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

function parseVid($url) {
    $video_id = '';
    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $video_id = $match[1];
    }
    return $video_id;
}

function video_teasers() {
    $query = db_select('node', 'n');
    $query->join('field_data_field_url', 'u', 'n.nid = u.entity_id');
    $query->leftJoin('field_data_field_image', 'i', 'n.nid = i.entity_id');
    $query->leftJoin('file_managed', 'f', 'f.fid = i.field_image_fid');
    $query->addField('n', 'title');
    $query->addField('u', 'field_url_value', 'video');
    $query->addField('f', 'uri', 'thumbnail');
    $result = $query->orderBy('n.title')
        ->condition('n.type', 'video', '=')
        ->condition('n.status', '1', '=')
        ->condition('n.promote', '1', '=')
        ->execute()
        ->fetchAll();

    foreach ($result as $key => $item) {
        $vid = parseVid($item->video);
        $result[$key]->video_id = $vid;
        $result[$key]->embed_url = "http://youtube.com/embed/{$vid}?rel=0&hd=1&border=0&controls=0&autoplay=1&showinfo=0&modestbranding=1";
        if (!$item->thumbnail) {
            $result[$key]->thumbnail = "http://img.youtube.com/vi/{$vid}/0.jpg";
        }
    }

    return $result;

    // Always return the larger image, since we're storing images locally.
    // $tn = "http://img.youtube.com/vi/{$item['value']}/0.jpg";

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

function tenshin_theme_process_html(&$variables) {
    $variables['css'] = array (
        'sites/all/themes/tenshin_theme/styles.css' => array (
            'group' => 100,
            'every_page' => 1,
            'media' => 'all',
            'type' => 'file',
            'weight' => 0,
            'preprocess' => 1,
            'data' => 'sites/all/themes/tenshin_theme/styles.css',
            'browsers' => array (
                'IE' => 1,
                '!IE' => 1
            )
        )
    );
    // Render page_top and page_bottom into top level variables.
    //$variables['page_top'] = drupal_render($variables['page']['page_top']);
    // $variables['page_bottom'] = drupal_render($variables['page']['page_bottom']);
    // // Place the rendered HTML for the page body into a top level variable.
    // $variables['page']              = $variables['page']['#children'];
    // $variables['page_bottom'] .= drupal_get_js('footer');

    // $variables['head']    = drupal_get_html_head();
    // $variables['css']     = drupal_add_css();
    // $variables['styles']  = drupal_get_css();
    // $variables['scripts'] = drupal_get_js();
    //die('<pre>'. print_r($variables['css'], true) .'</pre>');
}

function tenshin_theme_process_page(&$variables) {
    $variables['slider_images'] = slider_images();
    $variables['header_teasers'] = header_teasers();
    $variables['main_menu'] = main_menu();
    $variables['test_var'] = 'Hello';

    // Social links
    $variables['tw_link'] = theme_get_setting('tw_link', 'tenshin_theme');
    $variables['fb_link'] = theme_get_setting('fb_link', 'tenshin_theme');

    // Footer texts
    $variables['footer_text_1'] = theme_get_setting('footer_text_1', 'tenshin_theme');
    $variables['footer_text_2'] = theme_get_setting('footer_text_2', 'tenshin_theme');

    $variables['video_teasers'] = video_teasers();
    //die('<pre>'. print_r(request_path(), true) .'</pre>');
}

function tenshin_theme_process_node(&$variables) {
    $variables['test_var'] = 'Hello';
    $variables['path'] = request_path();
    
    if (in_array($variables['path'], array('media/photo', 'media/video'))) {
        $variables['theme_hook_suggestions'][] = 'node__media';
    }
}