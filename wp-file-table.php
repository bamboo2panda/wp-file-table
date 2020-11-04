<?php

/*
Plugin Name: WP File Table
Plugin URI: https://github.com/bamboo2panda/wp-file-table
Description: Wordpress plugin for creating managable tables of files. .
Version: 1.0
Author: bamboo2panda
Author URI: https://github.com/bamboo2panda/
License: GPL2
*/

defined('ABSPATH') or die ('No direct access to file!');

//Require once Composer Autoload
if (file_exists(__DIR__.'/vendor/autoload.php')){
	require_once dirname(__FILE__).'/vendor/autoload.php';
}

/**
 * Code runs during activation
 */
function activate_wp_file_table_plugin(){
	Inc\Base\Activate::activate();
}
register_activation_hook(__FILE__, 'activate_wp_file_table_plugin');

/**
 * Code runs during deactivation
 */
function deactivate_wp_file_table_plugin(){
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'deactivate_wp_file_table_plugin');

/**
 * Initialize all core classes of plugin
 */
if (class_exists('Inc\\Init')){
    Inc\Init::register_services();
}