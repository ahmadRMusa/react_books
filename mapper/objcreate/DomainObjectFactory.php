<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:47 AM
 */
namespace mapper;

use \domain\ObjectWatcher;
use \domain\DomainObject;

abstract class DomainObjectFactory
{
    /**
     * @param array $array raw data from database. An associative array that key is every field of the db
     * @return mixed
     */
    public abstract function createObject(array $array);

    // Identity map function
    protected function getFromMap($id)
    {
        // TODO: where should we have this method?
        return ObjectWatcher::exists($this->targetClass(), $id);
    }

    // Identity map function
    protected function addToMap(DomainObject $object)
    {
        ObjectWatcher::add($object);
    }

    protected abstract function targetClass();


}