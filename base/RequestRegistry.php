<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 12:13 AM
 */

use \controller\Request;

/**
 * Class RequestRegistry
 * @package base
 *
 *
 */
class RequestRegistry extends Registry
{

    private $values = array();
    private static $instance = null;

    private function __construct()
    {
    }

    static function instance()
    {
        if (is_null(self::instance())) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    static function getRequest()
    {
        $inst = self::instance();
        if (is_null($inst->get("request"))) {
            $inst->set('request', new Request());
        }
        return $inst->get("request");
    }

    protected function get($key)
    {
        // TODO: Implement get() method.
    }

    protected function set($key, $val)
    {
        // TODO: Implement set() method.
    }

}