<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 12:03 AM
 */

namespace mapper;

abstract class PersistenceFactory
{
    abstract public function getCollection(array $array);

    abstract public function getDomainObjectFactory();

    abstract public function getSelectionFactory();

    abstract public function getUpdateFactory();

    /**
     * @param $domainObject a domain type. for example, BookPersistenceFactory
     */
    public function getFactory($domainObject)
    {
        // TODO: implementation
    }

}