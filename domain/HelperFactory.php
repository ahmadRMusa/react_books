<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 5:52 PM
 */
namespace domain;

use mapper\PersistenceFactory;

class HelperFactory
{

    /**
     * @param $class_name
     * @return mixed
     *
     * Because the Domain Model needs to instantiate Collection objects, and because I may need to switch the
     * implementation at some point (especially for testing purposes), I provide a factory class in the Domain layer for
     * generating Collection objects on a type-by-type basis.
     *
     * Try to get an empty collection. Even though we do not provide raw data,
     * this make sense since we just want to get an empty collection. The concrete
     * PersistenceFactory will get the corresponding DomainObjectFactory when using
     * the parent Collection constructor to initialize a new Collection instance.
     */
    public static function getCollection($class_name)
    {
        $factory = PersistenceFactory::getFactory($class_name);
        // Try to get an empty collection
        return $factory->getCollection();
    }

    /**
     * @param $domain_object_name
     * @return \mapper\DomainObjectAssembler a $domain_object_name . "PersistenceFactory"
     */
    public static function getFinder($domain_object_name)
    {
        // we should get rid of the namespace here since we are going from domain to persistent layer
        $class_name = $domain_object_name;
        $pos = strrpos($class_name, "\\");
        if ($pos) {
            $class_name = substr($class_name, $pos + 1);
        }
        return PersistenceFactory::getFinder($class_name);
    }

}