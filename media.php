<?php
define('MEDIA_ITEMS_LIMIT', 12);

class Media {
    static function init(&$variables) {
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $offset = ($page - 1) * MEDIA_ITEMS_LIMIT;
        $group = isset($_GET['group']) ? intval($_GET['group']) : NULL;

        switch ($variables['node_url']) {
            case '/media':
                if ($group) {
                    $variables['group_title'] = self::getGroupName($group);
                    $variables['images'] = self::getImages($group, $offset, MEDIA_ITEMS_LIMIT);
                    $variables['items_count'] = self::getImagesCount($group);
                    $variables['pages_count'] = round($variables['items_count'] / MEDIA_ITEMS_LIMIT);
                    $variables['current_page'] = $page;
                } else {
                    $variables['terms'] = self::getGroups();
                }
            break;
            case '/media/video':
                $variables['videos'] = self::getVideos($offset, MEDIA_ITEMS_LIMIT);
                $variables['items_count'] = self::getVideosCount();
                $variables['pages_count'] = $variables['items_count'] / MEDIA_ITEMS_LIMIT;
                $variables['current_page'] = $page;
            break;
        }
    }

    static function getImages($group = NULL, $offset = 0, $limit = 4) {
        $query = db_select('taxonomy_index', 'ti');
        $query->join('node', 'n', 'n.nid = ti.nid');
        $query->join('field_data_field_image', 'i', 'n.nid = i.entity_id');
        $query->join('file_managed', 'f', 'f.fid = i.field_image_fid');
        return $query
            ->fields('f', array('uri'))
            ->fields('n', array('title'))
            ->orderBy('n.title')
            ->condition('n.type', 'image', '=')
            ->condition('n.status', '1', '=')
            ->condition('ti.tid', $group, '=')
            ->range($offset, $limit)
            ->execute()
            ->fetchAll();
    }

    static function getImagesCount($group = NULL) {
        $query = db_select('taxonomy_index', 'ti');
        $query->join('node', 'n', 'n.nid = ti.nid');
        return $query
            ->condition('n.type', 'image', '=')
            ->condition('n.status', '1', '=')
            ->condition('ti.tid', $group, '=')
            ->countQuery()
            ->execute()
            ->fetchField();
    }

    static function getGroupName($tid) {
        return db_select('taxonomy_term_data', 'td')
            ->fields('td', array('name'))
            ->condition('td.tid', $tid, '=')
            ->execute()
            ->fetchField();
    }

    static function getGroups($vocabulary_name = 'photo_gallary') {
        $vid = db_select('taxonomy_vocabulary', 'v')
            ->fields('v', array('vid'))
            ->condition('v.machine_name', $vocabulary_name, '=')
            ->execute()
            ->fetchField();
        $terms = db_select('taxonomy_term_data', 'td')
            ->fields('td', array('tid', 'name'))
            ->condition('td.vid', $vid, '=')
            ->execute()
            ->fetchAll();
        $result = array();
        foreach ($terms as $term) {
            $query = db_select('taxonomy_index', 'ti');
            $query->join('node', 'n', 'n.nid = ti.nid');
            $query->join('field_data_field_image', 'i', 'i.entity_id = n.nid');
            $query->join('file_managed', 'f', 'f.fid = i.field_image_fid');
            $query->addField('ti', 'nid');
            $query->addField('n', 'title');
            $query->addField('f', 'uri');
            $term->nodes = $query
                ->condition('ti.tid', $term->tid, '=')
                ->range(0, 4)
                ->execute()
                ->fetchAll();
            $result[$term->tid] = $term;
        }
        return $result;
    }

    static function getVideos($offset = 0, $limit = 4) {
        $query = db_select('node', 'n');
        $query->join('field_data_field_url', 'u', 'n.nid = u.entity_id');
        $query->leftJoin('field_data_field_image', 'i', 'n.nid = i.entity_id');
        $query->leftJoin('file_managed', 'f', 'f.fid = i.field_image_fid');
        $query->addField('n', 'title');
        $query->addField('u', 'field_url_value', 'video');
        $query->addField('f', 'uri', 'thumbnail');
        return $query->orderBy('n.title')
            ->condition('n.type', 'video', '=')
            ->condition('n.status', '1', '=')
            ->range($offset, $limit)
            ->execute()
            ->fetchAll();
    }

    static function getVideosCount() {
        $query = db_select('node', 'n');
        return $query
            ->condition('n.type', 'video', '=')
            ->condition('n.status', '1', '=')
            ->countQuery()
            ->execute()
            ->fetchField();
    }

    static function videoThumb($url) {
        $videoId = self::getVideoId($url);
        return "https://img.youtube.com/vi/{$videoId}/1.jpg";
    }

    static function videoUrl($url) {
        $videoId = self::getVideoId($url);
        return "https://youtube.com/embed/{$videoId}?rel=0&hd=1&border=0&controls=0&autoplay=1&showinfo=0&modestbranding=1";
    }

    static function getVideoId($url) {
        $video_id = '';
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $video_id = $match[1];
        }
        return $video_id;
    }
}
