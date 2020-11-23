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
namespace FilePostsInc\Api\Callbacks;


use FilePostsInc\Base\BaseController;

class FilePostsCallbacks extends BaseController
{

    public function saveFilePostData($post_id)
    {
        global $post;
        if (!key_exists('action', $_POST)){
            return false;
        }
        $meta = [
            'attachment_name' => $_POST['attachment_name'],
            'attachment_link' => $_POST['attachment_link'],
            'attachment_style' => $_POST['attachment_style'],

            'attachment_name_1' => $_POST['attachment_name_1'],
            'attachment_link_1' => $_POST['attachment_link_1'],
            'attachment_style_1' => $_POST['attachment_style_1'],

            'attachment_name_2' => $_POST['attachment_name_2'],
            'attachment_link_2' => $_POST['attachment_link_2'],
            'attachment_style_2' => $_POST['attachment_style_2'],

        ];

        update_post_meta($post_id, '_file_post_meta_key', $meta);
    }

    public function attachFile()
    {
        $links = array(
            array(
                'name'=>'attachment_name',
                'name_label'=>'Название ссылки',
                'link'=>'attachment_link',
                'link_label'=>'Основная ссылка',
                'style'=>'attachment_style',
            ),
            array(
                'name'=>'attachment_name_1',
                'name_label'=>'Название ссылки 1',
                'link'=>'attachment_link_1',
                'link_label'=>'Дополнительная ссылка 1',
                'style'=>'attachment_style_1',
            ),
            array(
                'name'=>'attachment_name_2',
                'name_label'=>'Название ссылки 2',
                'link'=>'attachment_link_2',
                'link_label'=>'Дополнительная ссылка 2',
                'style'=>'attachment_style_2',
            ),
        );
        foreach ($links as $link){
            $this->inputAttachmentName($link);
            $this->inputAttachmentLink($link);
            $this->inputAttachmentStyle($link);
        }
    }

    private function inputAttachmentName(array $link)
    {
        echo '<p>';
        $this->labelAttachmentName($link['name_label'], $link['name']);
        $link_name = $this->getPostMetaParam($link['name']);

        echo '
            <input 
                type="text" 
                value="'.$link_name.'" 
                name="'.$link['name'].'" 
                id="'.$link['name'].'"
            >';
        echo '</p>';
    }

    private function inputAttachmentLink(array $link)
    {
        echo '<p>';
        $this->labelAttachmentLink($link['link_label'], $link['link']);
        $attachment_link = $this->getPostMetaParam($link['link']);
        echo '
            <input 
                type="text" 
                value="'.$attachment_link.'" 
                name="'.$link['link'].'" 
                id="'.$link['link'].'"
            >';
        echo '</p>';
    }


    private function inputAttachmentStyle(array $link)
    {
        $attachment_style = $this->getPostMetaParam($link['style']);

        echo '
            <select name="'.$link['style'].'" id="'.$link['style'].'">
                <option value="blue" '. ($attachment_style == "blue" ? "selected" : " ") .'>Синяя кнопка</option>
                <option value="green" '. ($attachment_style == "green" ? "selected" : " ")  .'>Зелёная кнопка</option>
                <option value="red" '. ($attachment_style == "red" ? "selected" : " ") .'>Красная кнопка</option>
                <option value="simple" '. ($attachment_style == "simple" ? "selected" : " ").'>Простая ссылка</option>
            </select>';
    }

    private function labelAttachmentLink($label, $link)
    {
        echo '<p><label for="'.$link.'">'.$label.'</label>';
    }

    private function labelAttachmentName($label, $link_name)
    {
        echo '<label for="'.$link_name.'">'.$label.'</label>';
    }

    private function getPostMetaParam($name)
    {
        global $post;
        $meta = get_post_meta($post->ID, '_file_post_meta_key', true);
        return is_array($meta) && key_exists($name, $meta) ? $meta[$name] : '';
    }

}