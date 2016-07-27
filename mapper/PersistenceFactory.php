<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 12:03 AM
 */

namespace mapper {

    abstract class PersistenceFactory
    {
        abstract public function getCollection(array $array);

        abstract public function getDomainObjectFactory();

        abstract public function getSelectionFactory();

        abstract public function getUpdateFactory();

        abstract public function getIdentityObject();

        /**
         * @param $domain_object
         * @return DomainObjectAssembler with specific type of factory initiated
         *
         */
        public static function getFinder($domain_object)
        {
            $finder = new DomainObjectAssembler(self::getFactory($domain_object));
            return $finder;
        }

        /**
         * @param $domain_object the name of the domain class
         * @return mixed an persistence factory of a specific type
         *
         */
        public static function getFactory($domain_object)
        {
            $class_name = $domain_object . "PersistenceFactory";
            $namespace = "mapper\\";
            $class = $namespace . $class_name;
            // TODO: check if this class exists
            $factory = new $class();
            return $factory;
        }

    }
}

