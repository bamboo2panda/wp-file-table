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
namespace Inc\Base;


class Deactivate
{

    public static function deactivate()
    {
        flush_rewrite_rules();
    }

    public static function deactivation($dir)
    {
        register_deactivation_hook(__FILE__, array('WpFileTableDeactivate', 'deactivate'));
    }
}