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

    protected abstract function update(DomainObject $obj);

    protected abstract function doInsert(DomainObject $obj);

    protected abstract function selectStmt();

    protected abstract function targetClass();

    /**
     * @param $id
     * @return mixed|null
     *
     *
     * TODO: This kind of methods can be replaced by selection factory
     *
     * find obj in identity map first then initialize a new one
     *
     * Both find() and createObject() first check for an existing object by passing the table ID to getFromMap().
     * If an object is found, it is returned to the client and method execution ends.
     *
     * If, however, there is no version of this object in existence yet,
     * object instantiation goes ahead.
     *
     * In createObject(), the new object is passed to addToMap() to prevent any clashes in the future.
     *
     * TODO: Anything related to Collection?
     *
     * TODO: This should be replaced by DomainObjectAssembler::find();
     *
     */
    public function find($id)
    {
        $old = $this->getFromMap($id);

        if (!is_null($old)) {
            return $old;
        }

        // look into database then create an obj

        // mock raw data
        $result = array();

        // create an object and return
        $obj = $this->createObject($result);
        return $obj;
    }

    /**
     * @param $array
     * @return mixed
     *
     * delegate create object to child classes
     *
     */


    // delegate to child class
    public function insert(DomainObject $obj)
    {
        $this->addToMap($obj);
    }

    /**
     * TODO: need to return a Collection here
     */
    function findAll()
    {

    }


}