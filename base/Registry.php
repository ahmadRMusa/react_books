<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/22/16
 * Time: 11:56 PM
 */
abstract class Registry
{
    abstract protected function get($key);

    abstract protected function set($key, $val);

}