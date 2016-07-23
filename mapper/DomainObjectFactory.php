<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:47 AM
 */
abstract class DomainObjectFactory
{
    abstract function createObject(array $array);

}