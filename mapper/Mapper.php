<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:01 PM
 */

use \domain\DomainObject;

abstract class Mapper
{
    function __construct()
    {
        // get db connection
    }

    // look for an object via id
    function find($id)
    {
        // get the raw data from database
    }

    // delegate create object to child classes
    function createObject($array)
    {

    }

    // delegate to child class
    function insert(DomainObject $obj)
    {

    }

    protected abstract function update(DomainObject $obj);

    protected abstract function doCreateObject(array $array);

    protected abstract function doInsert(DomainObject $obj);

    protected abstract function selectStmt();


}