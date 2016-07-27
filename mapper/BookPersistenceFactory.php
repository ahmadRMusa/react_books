<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 12:05 AM
 */
namespace mapper;

class BookPersistenceFactory extends PersistenceFactory
{
    public function getIdentityObject()
    {
        return new BookIdentityObject();
    }

    public function getCollection(array $raw_data)
    {
        // If the child does not define a constructor then it may be inherited from the parent class
        // just like a normal class method (if it was not declared as private).
        return new BookCollection($raw_data, self::getDomainObjectFactory());
    }

    public function getDomainObjectFactory()
    {
        return new BookObjectFactory();
    }

    public function getSelectionFactory()
    {
        return new BookSelectionFactory();
    }

    public function getUpdateFactory()
    {
        return new BookUpdateFactory();
    }


}