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

/**
 * Class DomainObjectFactory
 * @package mapper
 *
 * this class is responsible for creating object
 *
 */
abstract class DomainObjectFactory
{
    /**
     * @param array $raw_data raw data from database. An associative array that key is every field of the db
     * @return mixed
     *
     * Initialize a new object from raw data, not construct a new object.
     *
     */
    public abstract function createObject(array $raw_data);

    /**
     * @param $id
     * @return mixed|null
     *
     * with the id and class that calls this method, we check the identity map
     * if this object has already been initiated.
     *
     * return that object if exists, null if not.
     *
     * It make sense to put getFromMap and addToMap here since this is the only place that generate an object.
     *
     */
    protected function getFromMap($id)
    {
        return ObjectWatcher::exists($this->targetClass(), $id);
    }

    /**
     * @param DomainObject $object
     *
     * This method is called to add an domain object to identity map.
     * It will only be called when a new object get initialized.
     */
    protected function addToMap(DomainObject $object)
    {
        ObjectWatcher::add($object);
    }

    /**
     * @return mixed
     *
     * call down to the child implementation to get the name of the class currently awaiting instantiation.
     */
    protected abstract function targetClass();


}