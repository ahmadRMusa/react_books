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
     */
    public static function getCollection($class_name)
    {

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