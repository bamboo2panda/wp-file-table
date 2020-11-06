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


use Inc\Api\Callbacks\RenderCallbacks;

class RenderController
{
    private $renderCallbacks;

    public function __construct()
    {
        $this->renderCallbacks = new RenderCallbacks();
    }

    public function register()
    {
        add_shortcode('file_list', array($this->renderCallbacks, 'renderFileListShortcode'));
    }
}