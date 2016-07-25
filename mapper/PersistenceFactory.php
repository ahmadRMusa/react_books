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
    abstract protected function getCollection(array $array);

    abstract protected function getDomainObjectFactory();

    /**
     * @param $domainObject a domain type
     */
    public function getFactory($domainObject)
    {
        // TODO: implementation
    }

}