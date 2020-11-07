<?php

/*
Plugin Name: WP File Table
Plugin URI: https://github.com/bamboo2panda/wp-file-table
Description: Wordpress plugin for creating manageable tables of files.
Version: 1.0
Author: bamboo2panda
Author URI: https://github.com/bamboo2panda/
License: GPL2
*/
namespace FilePostsInc\Base;

class ActivateFilePosts{

    public static function activate()
    {
        flush_rewrite_rules();

        $default = array();
        if (! get_option('wp_file_table_plugin')){
            update_option('wp_file_table_plugin', $default);
        }
    }

    public function activation($dir, $plugin)
    {
        register_activation_hook(PLUGIN_PATH, array($plugin, 'activate'));
    }
}