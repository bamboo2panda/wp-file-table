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
namespace FilePostsInc\Base;


use FilePostsInc\Api\Callbacks\FilePostsCallbacks;

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
                'label' => null,
                'labels'      => array(
                    'name'          => __('Файлы'),
                    'singular_name' => __('Файл'),
                    'add_new' => __('Добавить файл'),
                    'add_new_item' => __('Добавление файла'),
                    'edit_item'          => 'Редактирование файла', // для редактирования типа записи
                    'new_item'           => 'Новый файл', // текст новой записи
                    'view_item'          => 'Смотреть файл', // для просмотра записи этого типа.
                    'search_items'       => 'Искать файлы', // для поиска по этим типам записи
                    'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
                    'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
                    'parent_item_colon'  => '', // для родителей (у древовидных типов)
                    'menu_name'          => 'Таблицы файлов', // название меню
                ),
                'menu_position' => 2,
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
                'file_post_attachments',           // Unique ID
                'Прикреплённые файлы',  // Box title
                array($this->filePostsCallbacks, 'attachFile'),  // Content callback, must be of type callable
                $screen,
                'side'
            );
            add_meta_box(
                'file_post_thumbnail',           // Unique ID
                'Превью',  // Box title
                array($this->filePostsCallbacks, 'addPreview'),  // Content callback, must be of type callable
                $screen,
                'side'
            );
        }
    }

}