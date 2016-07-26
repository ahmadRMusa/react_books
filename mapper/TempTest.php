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
        $factory = PersistenceFactory::getFactory("");
        $idobj = $factory->getIdentityObject()->field('title')->eq('xxxx');
        $finder = PersistenceFactory::getFinder();
        $collection = $finder->find($idobj);

        // output result
        print_r($collection);
    }

}