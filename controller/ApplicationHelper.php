<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/22/16
 * Time: 11:55 PM
 */

namespace controller;

/**
 * Class ApplicationHelper
 * @package controller
 *
 * This class simply reads a configuration file and makes values available to clients.
 *
 * TODO: Both ApplicationRegistry and ApplicationHelper use hard-coded paths to work with files.
 * In a real-world deployment, these file paths would probably be configurable and acquired through a registry
 * or configuration object.
 *
 */
class ApplicationHelper
{

    private static $instance = null;
    // TODO: path to the configuration file?
    private $config = "/shared/ctrl_options.xml";

    private function __construct()
    {
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // responsible for loading configuration data
    function init()
    {

    }

    private function getOptions()
    {
        // TODO: Check file exists

        $options = \simplexml_load_file($this->config);

        $map = new ControllerMap();

        // TODO: set up the map here


    }

}