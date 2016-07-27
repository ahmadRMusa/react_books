<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 2:29 AM
 */

namespace mapper;


class TempTest
{

    public function runTest()
    {
        $factory = PersistenceFactory::getFactory("Book");
        $idobj = $factory->getIdentityObject()->field('title')->eq('advanced php');
        $finder = PersistenceFactory::getFinder("Book");
        $collection = $finder->find($idobj);

        // output result
        // print_r($collection);
    }

}