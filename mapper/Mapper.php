<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:01 PM
 */

use \domain\DomainObject;
use \domain\ObjectWatcher;

abstract class Mapper
{
    function __construct()
    {
        // get db connection
    }

    protected abstract function update(DomainObject $obj);

    protected abstract function doCreateObject(array $array);

    protected abstract function doInsert(DomainObject $obj);

    protected abstract function selectStmt();

    protected abstract function targetClass();

    private function getFromMap($id)
    {
        return ObjectWatcher::exists($this->targetClass(), $id);
    }

    private function addToMap(DomainObject $object)
    {
        ObjectWatcher::add($object);
    }


    /**
     * @param $id
     * @return mixed|null
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
    public function createObject($array)
    {
        $old = $this->getFromMap($array['id']);

        if (!is_null($old)) {
            return $old;
        }

        $obj = $this->doCreateObject($array);
        $this->addToMap($obj);
        return $obj;
    }

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