<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 12:23 AM
 */

namespace base;
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
class ApplicationRegistry extends \Registry
{

    private static $instance = null;
    private $values = array();

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

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->request)) {
            $inst->request = new \controller\Request();
        }
        return $inst->request;
    }

}