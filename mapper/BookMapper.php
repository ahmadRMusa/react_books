<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:27 PM
 */

/**
 * Class BookMapper
 *
 * @Deprecated we will not use this class in the future
 */
use \domain\DomainObject;

class BookMapper extends Mapper
{

    function __construct()
    {
        // prepare statements for query
    }

    function getCollection()
    {
        // get a collection of books
    }

    protected function doCreateObject(array $array)
    {
        // TODO: Implement doCreateObject() method.
        // return an Book Object to Client
    }

    protected function doInsert(DomainObject $obj)
    {
        // TODO: Implement doInsert() method.
    }

    protected function update(DomainObject $obj)
    {
        // TODO: Implement update() method.
    }

    protected function selectStmt()
    {
        // TODO: Implement selectStmt() method.
    }


}