<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/28/16
 * Time: 3:19 PM
 */

namespace mapper;


use domain\ObjectWatcher;

class TestUpdateTransaction
{
    public function runTest()
    {
        $factory = PersistenceFactory::getFactory("Book");
        $idobj = $factory->getIdentityObject()->field('author')->eq('jie');
        $finder = PersistenceFactory::getFinder("Book");

        $collection = $finder->find($idobj);
        while ($collection->current()) {
            $book = $collection->current();
            $book->setDescription("famous author jie!");
            $collection->next();
        }

        $book = $finder->findOne($idobj);
        print_r($book);

        ObjectWatcher::instance()->performOperations();
    }
}