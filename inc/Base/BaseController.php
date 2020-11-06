<?php


namespace Inc\Base;


class BaseController
{
    /**
     * @var string
     */
    public $plugin_path;
    /**
     * @var string
     */
    public $plugin_url;
    /**
     * @var string
     */
    public $plugin;

    public function activated($name){
        $option = get_option('wp-file-table');
        return isset ($option[$name]) ? $option[$name] : false;
    }

    public function __construct()
    {
        $this->plugin_path = plugin_dir_path(dirname(__FILE__, 2));
        $this->plugin_url = plugin_dir_url(dirname(__FILE__, 2));
        $this->plugin = plugin_basename(dirname(__FILE__, 3)).'/wp-file-table.php';
    }
}