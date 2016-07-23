<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/22/16
 * Time: 11:56 PM
 */

namespace base;


abstract class Registry
{

    private static $instance = null;
    private $values = array();

    private function __construct()
    {
    }

    abstract protected function get($key);

    abstract protected function set($key, $val);


}