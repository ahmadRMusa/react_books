<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 12:23 AM
 */

namespace base;

use controller\AppController;
use controller\ControllerMap;
use controller\Request;

/**
 * Class ApplicationRegistry
 * @package base
 *
 * There is no corresponding setRequest() method.
 * Instead of allowing third-party objects to instantiate and lodge their own Request objects,
 * this mechanism makes the Registry the sole source of a shared Request
 * and provides some guarantee that only a single Request instance will be available across the system.
 *
 */
class ApplicationRegistry extends Registry
{

    private static $instance = null;
    private static $controller_map = null;
    private $request = null;
    private $appController = null;

    private function __construct()
    {
    }

    /**
     * @return array with db information
     */
    public static function getDBInfo()
    {
        return array('servername' => "localhost", "username" => "root", "password" => "susie19910401", "dbname" => "react_book");
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key)
    {
        // TODO: Implement get() method.
    }

    protected function set($key, $val)
    {
        // TODO: Implement set() method.
    }

    // TODO: Should we get request from here? Should not to be from RequestRegistry?
    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->request)) {
            $inst->request = new Request();
        }
        return $inst->request;
    }

    static function setControllerMap(ControllerMap $map)
    {
        // we don't want to set up it again!
        if (!is_null(self::$controller_map)) {
            throw new \Exception("Controller Map has already set!");
        }
        self::$controller_map = $map;
    }

    static function getControllerMap()
    {
        // check if it is set already
        if (is_null(self::$controller_map)) {
            // TODO: ERROR
            throw new \Exception("Controller Map has not set yet!");
        }

        return self::$controller_map;
    }

    static function getAppController()
    {
        $inst = self::instance();
        if (is_null($inst->appController)) {
            // TODO: where shall I init control map?
            $inst->appController = new AppController();
        }
        return $inst->appController;
    }

}