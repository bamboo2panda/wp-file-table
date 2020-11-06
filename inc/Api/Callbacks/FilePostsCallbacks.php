<?php
/*
Plugin Name: WP File Table
Plugin URI: https://github.com/bamboo2panda/wp-file-table
Description: Wordpress plugin for creating manageable tables of files. .
Version: 1.0
Author: bamboo2panda
Author URI: https://github.com/bamboo2panda/
License: GPL2
*/
namespace Inc\Api\Callbacks;


use Inc\Base\BaseController;

class FilePostsCallbacks extends BaseController
{

    public function saveFilePostData($post_id)
    {
        global $post;
        if (!key_exists('action', $_POST)){
            return false;
        }
        $meta = [
            'attachment_link' => $_POST['attachment_link'],
        ];

        update_post_meta($post_id, '_file_post_meta_key', $meta);
    }

    public function attachFile()
    {
        echo '<a href="/wp-admin/media-upload.php?post_id=271&amp;type=file&amp;TB_iframe=1&amp;width=753&amp;height=270" id="set-post-thumbnail" class="thickbox">Установить изображение записи</a>';
        $this->inputAttachmentLink();
    }

    private function inputAttachmentLink()
    {
        $file_link = $this->getAttachmentLink();
        echo '
            <p>
                <label for="attachment_link">Ссылка на файл</label>
                <input 
                    type="text" 
                    value="'.$file_link.'" 
                    name="attachment_link" 
                    id="attachment_link"
                >
            </p>
        ';
    }

    private function getAttachmentLink()
    {
        global $post;
        $meta = get_post_meta($post->ID, '_file_post_meta_key', true);
        return $meta['attachment_link'];
    }
}