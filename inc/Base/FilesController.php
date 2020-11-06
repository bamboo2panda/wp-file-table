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
namespace Inc\Base;


use Inc\Api\Callbacks\FilePostsCallbacks;

class FilesController
{

    public $filePostsCallbacks;

    public function __construct()
    {
        $this->filePostsCallbacks = new FilePostsCallbacks();
    }

    public function register()
    {
        add_action('init', array($this, 'makeFilePostType'));
        add_action('init', array($this, 'makeShortcodePostType'));
        add_action('init', array($this, 'makeFileCategoryTaxonomy'));
        add_action('add_meta_boxes', array($this, 'addMetaBoxes'));
        add_action('save_post_file_post', array($this->filePostsCallbacks, 'saveFilePostData'));
    }

    public function makeFilePostType()
    {
        register_post_type('file_post',
            array(
                'labels'      => array(
                    'name'          => __('Файлы'),
                    'singular_name' => __('Файл'),
                ),
                'public'      => true,
                'has_archive' => false,
            )
        );
        return true;
    }

    public function makeShortcodePostType()
    {
        register_post_type('shortcode_file_table',
            array(
                'labels'      => array(
                    'name'          => __('Шорткоды'),
                    'singular_name' => __('Шорткод'),
                ),
                'public'      => true,
                'has_archive' => false,
                'show_in_menu'=> 'edit.php?post_type=file_post',
            )
        );
        return true;
    }

    public function makeFileCategoryTaxonomy()
    {
        register_taxonomy( 'file_category', [ 'file_post' ], [
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => [
                'name'              => 'Категории файлов',
                'singular_name'     => 'Категория',
                'search_items'      => 'Поиск категорий',
                'all_items'         => 'Все категории',
                'view_item '        => 'Посмотреть категорию',
                'parent_item'       => 'Родительская категория',
                'parent_item_colon' => 'Родительская категория:',
                'edit_item'         => 'Редактировать категорию',
                'update_item'       => 'Обновить категорию',
                'add_new_item'      => 'Добавить новую категорию',
                'new_item_name'     => 'Название новой категории',
                'menu_name'         => 'Категории файлов',
            ],
            'description'           => 'Категории файлов. Используются для выборки в шорткодах.',
            'public'                => true,
            'hierarchical'          => true,
            'rewrite'               => true,
            'capabilities'          => array(),
            'meta_box_cb'           => null,
            'show_admin_column'     => false,
            'show_in_rest'          => null,
            'rest_base'             => null,
        ] );
        return true;
    }
    function addMetaBoxes()
    {
        $screens = ['file_post'];
        foreach ($screens as $screen) {

            add_meta_box(
                'file_post_attachment',           // Unique ID
                'Прикреплённый файл ',  // Box title
                array($this->filePostsCallbacks, 'attachFile'),  // Content callback, must be of type callable
                $screen,
                'side'
            );
        }
    }

}