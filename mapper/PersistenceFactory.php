<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 12:03 AM
 */
abstract class PersistenceFactory
{
    abstract protected function getCollection(array $array);

    abstract protected function getDomainObjectFactory();

    public function getFactory($factoryType)
    {
        // TODO: implementation
    }

}