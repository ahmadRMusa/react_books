<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:48 AM
 */

use \domain\Book;

class BookObjectFactory extends DomainObjectFactory
{
    /**
     * @param array $array raw data get from database query
     * @return Book
     */
    function createObject(array $array)
    {
        // get raw data and then assemble a new book
        $obj = new Book();

        // setters

        return $obj;
    }
}