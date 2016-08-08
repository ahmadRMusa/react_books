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
        /**
         * @param array $array
         * @return mixed
         *
         * transform from raw data to domain object
         */
        abstract public function getCollection(array $array);

        /**
         * @return mixed
         *
         * generating domain object
         */
        abstract public function getDomainObjectFactory();

        /**
         * @return mixed
         *
         * Identity Object for generating query criteria
         */
        abstract public function getIdentityObject();

        /**
         * @return mixed
         *
         * For selection
         */
        abstract public function getSelectionFactory();

        /**
         * @return mixed
         *
         * For updating
         */
        abstract public function getUpdateFactory();

        /**
         * @param $domain_object_name to initialize the factory attribute in a domain object assembler
         * @return DomainObjectAssembler with specific type of factory initiated
         *
         * a domain object assembler that can performs CURD
         *
         */
        public static function getFinder($domain_object_name)
        {
            $finder = new DomainObjectAssembler(self::getFactory($domain_object_name));
            return $finder;
        }

        /**
         * @param $domain_object_name
         * @return mixed
         *
         * get an specific child implementation
         *
         */
        public static function getFactory($domain_object_name)
        {
            $class_name = $domain_object_name . "PersistenceFactory";
            // persistence factory are always under this namespace
            $namespace = "mapper\\";
            $class = $namespace . $class_name;
            // TODO: check if this class exists
            $factory = new $class();
            return $factory;
        }

    }
}

