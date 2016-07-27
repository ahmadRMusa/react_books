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
     */

    public function createObject(array $raw_data)
    {
        // the raw data uses isbn as the key, not id
        //$old = $this->getFromMap($raw_data['isbn']);

        /*if (!is_null($old)) {
            return $old;
        }*/

        // create an object
        $obj = $this->doCreateObject($raw_data);
        //$this->addToMap($obj);
        return $obj;
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

    protected function targetClass()
    {
        return Book::class;
    }

    private function doCreateObject($raw_data)
    {
        $isbn = $raw_data['isbn'];
        $author = $raw_data['author'];
        $title = $raw_data['title'];
        $catid = $raw_data['catid'];
        $price = $raw_data['price'];
        $description = $raw_data['description'];
        $shouldPersist = false;

        return new Book($isbn, $author, $title, $catid, $price, $description, $shouldPersist);
    }

}