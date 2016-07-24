<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:47 AM
 */
abstract class DomainObjectFactory
{
    /**
     * @param array $array an associative array that key is every field of the db
     * @return mixed
     */
    public abstract function createObject(array $array);

}