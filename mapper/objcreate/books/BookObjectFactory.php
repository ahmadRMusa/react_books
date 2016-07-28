<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:48 AM
 */

namespace mapper;

use \domain\Book;
use \domain\DomainObject;

class BookObjectFactory extends DomainObjectFactory
{
    /**
     * @param array $raw_data raw data get from database query
     * @return Book Object
     *
     * Since this is a specific implementation for the Book Object factory,
     * we can customize all the fields we need for Book class
     *
     * find obj in identity map first then initialize a new one
     *
     * Both find() and createObject() first check for an existing object by passing the table ID to getFromMap().
     * If an object is found, it is returned to the client and method execution ends.
     *
     * If, however, there is no version of this object in existence yet,
     * object instantiation goes ahead.
     *
     * In createObject(), the new object is passed to addToMap() to prevent any clashes in the future.
     *
     */

    public function createObject(array $raw_data)
    {
        // TODO: After mapping we are able to use field name but not index
        // $old = $this->getFromMap($raw_data['id']);
        $old = $this->getFromMap($raw_data[0]);

        if (!is_null($old)) {
            return $old;
        }

        // create an object
        $obj = $this->doCreateObject($raw_data);
        $this->addToMap($obj);
        return $obj;
    }

    /**
     * @return mixed the class type of the domain object
     */
    protected function targetClass()
    {
        return Book::class;
    }

    private function doCreateObject($raw_data)
    {
        // TODO: mapping
        $id = $raw_data[0];
        $isbn = $raw_data['isbn'];
        $author = $raw_data['author'];
        $title = $raw_data['title'];
        $catid = $raw_data['catid'];
        $price = $raw_data['price'];
        $description = $raw_data['description'];
        $shouldPersist = false;

        return new Book($id, $isbn, $author, $title, $catid, $price, $description, $shouldPersist);
    }

}