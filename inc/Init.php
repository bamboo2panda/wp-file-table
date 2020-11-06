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
namespace Inc;
use Inc\Base;

final class Init
{
    /**
     * Store all classes inside array
     */
    public static function get_services()
    {
        return
            [
                Base\FilesController::class,
                Base\RenderController::class,
            ];
    }

    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exist
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class)
        {
            $service = self::instantiate($class);
            if (method_exists($service, 'register')){
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param $class
     * @return mixed
     */
    private static function instantiate($class)
    {
        return new $class();
    }
}