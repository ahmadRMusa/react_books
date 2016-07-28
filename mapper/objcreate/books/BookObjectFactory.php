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