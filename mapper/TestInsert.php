<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/28/16
 * Time: 2:23 AM
 */

namespace mapper;


use domain\Book;

class TestInsert
{

    public function runTest()
    {

        $object = new Book(null, '98765', 'lou', 'how to advance php', 1, 44.2, 'fantastic good book', true);

        $finder = PersistenceFactory::getFinder("Book");
        $finder->insert($object);

    }

}