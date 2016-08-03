<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/22/16
 * Time: 11:55 PM
 */

namespace controller;

use base\ApplicationRegistry;
use command\Command;

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
    private $config = "shared/ctrl_options.xml";

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
        $this->getOptions();
    }

    private function getOptions()
    {
        // TODO: set up the map here
        $this->parseForwadingChain();

    }

    private function parseForwadingChain()
    {
        // print_r($options);
        /**
         * SimpleXMLElement Object (
         *  [view] => Array ( [0] => main [1] => main [2] => error )
         *  [command] => Array (
         *      [0] => SimpleXMLElement Object ( [@attributes] => Array ( [name] => Login ) [view] => Login [comment] => SimpleXMLElement Object ( ) )
         *      [1] => SimpleXMLElement Object ( [@attributes] => Array (
         *          [name] => QuickAddVenue )
         *          [classroot] => SimpleXMLElement Object ( [@attributes] => Array ( [name] => AddVenue ) )
         *          [view] => quickadd )
         *      [2] => SimpleXMLElement Object ( [@attributes] => Array (
         *          [name] => AddVenue )
         *          [view] => addvenue
         *          [status] => SimpleXMLElement Object ( [@attributes] => Array ( [value] => CMD_OK ) [forward] => AddSpace ) ) ) [comment] => SimpleXMLElement Object ( ) )
         */

        $map = new ControllerMap();

        // TODO: Check file exists
        $options = \simplexml_load_file($this->config);

        // set up the default view
        foreach ($options->view as $default_view) {
            $status_str = trim($default_view['status']);
            $status = Command::reformatStatus($status_str);
            $map->addView((string)$default_view, 'default', $status);
        }

        // set up forwarding chain
        foreach ($options->command as $command) {
            // command name
            $command_name = (string)$command['name'];
            // parse the command
            foreach ($command->children() as $class_view) {
                // check the name of the tag
                $name = $class_view->getName();
                if ($name == 'view') {
                    $map->addView((string)$class_view, $command_name);
                } else if ($name == 'status') {
                    // parsing forward
                    $map->addForward($command_name, Command::reformatStatus(trim($class_view['value'])), (string)$class_view->forward);
                } else if ($name == 'classroot') {
                    $map->addClassroot($command_name, (string)$class_view['name']);
                } else {
                    // TODO: ERROR
                }
            }
        }

        ApplicationRegistry::setControllerMap($map);

    }

}