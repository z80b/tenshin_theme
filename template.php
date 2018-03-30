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
        $result[$key]->embed_url = "https://youtube.com/embed/{$vid}?rel=0&hd=1&border=0&controls=0&autoplay=1&showinfo=0&modestbranding=1";
        if (!$item->thumbnail) {
            $result[$key]->thumbnail = "https://img.youtube.com/vi/{$vid}/1.jpg";
        }
    }

    return $result;
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

function sub_menu($nid = NULL) {
    if (!$nid) return NULL;
    $link = db_select('menu_links', 'm')
        ->fields('m', array('mlid', 'plid'))
        ->condition('m.link_path', "node/{$nid}", '=')
        ->execute()
        ->fetchObject();
    if (isset($link) && is_object($link)) {
        $id = ($link->plid == 0) ? $link->mlid : $link->plid;
        return db_select('menu_links', 'm')
            ->fields('m', array('link_title', 'link_path'))
            ->orderBy('m.weight', 'ASC')
            ->condition('m.plid', $id, '=')
            ->execute()
            ->fetchAll();
    } else return NULL;
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
}

function get_contacts_content() {
    $path = db_select('url_alias', 'u')
        ->fields('u', array('source'))
        ->condition('u.alias', "contacts", '=')
        ->execute()
        ->fetchField();
    if ($path) {
        $node = node_load(arg(1, $path));
        return $node->body['und'][0]['value'];
    }
    return '';
}

function get_images_nodes_thumbs() {
    $results = db_select('node', 'n')
        ->fields('n', array('nid', 'title'))
        ->condition('n.type', 'image', '=')
        ->condition('n.status', '1', '=')
        ->condition('n.promote', '1', '=')
        ->execute()
        ->fetchAll();
    
    foreach ($results as $index => $node) {
        print_r($node);
        $query = db_select('field_data_field_image', 'i');
        $query->join('file_managed', 'f', 'f.fid = i.field_image_fid');
        $results[$index]->images = $query
            ->fields('i', array('field_image_title'))
            ->fields('f', array('uri'))
            ->condition('i.entity_id', $node->nid, '=')
            ->range(0, 3)
            ->execute()
            ->fetchAll();
    }
    return $results;
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
    $variables['current_path'] = current_path();

    $variables['contacts'] = get_contacts_content();

    switch (request_path()) {
        case 'media/photo':
            $variables['media'] = get_images_nodes_thumbs();
            break;
    }

    if (isset($_GET['update']) && $_GET['update'] == 'start') {
        //tenshin_ipdate_db();
    }

    die('<pre>'. print_r($variables['media'], true) .'</pre>');
}

function tenshin_theme_process_node(&$variables) {
    $variables['test_var'] = 'Hello';
    $variables['path'] = request_path();
    $variables['sub_menu'] = sub_menu($variables['nid']);
    
    if (in_array($variables['path'], array('media/photo', 'media/video'))) {
        $variables['theme_hook_suggestions'][] = 'node__media';
    }

    //die('<pre>'. print_r($variables, true) .'</pre>');
}

// function tenshin_ipdate_db() {

//     function replaceNodeLinks(&$body) {
//         $newbody = preg_replace_callback('/\/node\/(\d+)/i', function($matches) {
//             $old_node_id = $matches[1];
//             $new_node_id = db_select('migrate_map_e53bb1b10nodepage', 'm')
//                 ->fields('m', array('destid1'))
//                 ->condition('m.sourceid1', $old_node_id, '=')
//                 ->execute()
//                 ->fetchField();
//             $node_alias = drupal_get_path_alias("node/{$new_node_id}");
//             if (isset($new_node_id) && $new_node_id) {
//                 print("<p>node/{$matches[1]} -> node/{$new_node_id} -> {$node_alias}</p>\n");
//             }
//             return "/{$node_alias}";
//         }, $body->body_value);
//     }

//     function replaceNodeImagesLinks(&$body) {
//         $newbody = preg_replace_callback('/\/images\/images/i', function($matches) {
//             print("<p>node_id: {$body->entity_id}   {$matches[0]}</p>\n");
//             return '/images';
//         }, $body->body_value);
//     }

//     $bodys = db_select('field_data_body', 'b')->fields('b')->execute()->fetchAll();
//     foreach ($bodys as $body) {

//         $newbody = preg_replace_callback('/\/node\/(\d+)/i', function($matches) {
//             $old_node_id = $matches[1];
//             $new_node_id = db_select('migrate_map_e53bb1b10nodepage', 'm')
//                 ->fields('m', array('destid1'))
//                 ->condition('m.sourceid1', $old_node_id, '=')
//                 ->execute()
//                 ->fetchField();
//             $node_alias = drupal_get_path_alias("node/{$new_node_id}");
//             if (isset($new_node_id) && $new_node_id) {
//                 print("<p>node/{$matches[1]} -> node/{$new_node_id} -> {$node_alias}</p>\n");
//             }
//             return "/{$node_alias}";
//         }, $body->body_value);

//         if ($newbody && $newbody != $body->body_value) {
//             //print($newbody);
//             db_update('field_data_body')
//                 ->fields(array('body_value' => $newbody))
//                 ->condition('entity_id', $body->entity_id, '=')
//                 ->execute();
//         }
//     }
//     die();
//     //die('<pre>'. print_r($migrate_map, true) .'</pre>');
// }