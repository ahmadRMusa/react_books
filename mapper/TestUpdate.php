<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/28/16
 * Time: 12:36 AM
 */

namespace mapper;


class TestUpdate
{

    public function runTest()
    {
        $factory = PersistenceFactory::getFactory("Book");
        $idobj = $factory->getIdentityObject()->field('author')->eq('jie');
        $finder = PersistenceFactory::getFinder("Book");
        $collection = $finder->find($idobj);
        $object = $collection->current();
        $object->setTitle('program php');
        $finder->insert($object);
        $collection2 = $finder->find($idobj);
        while ($collection2->current()) {
            print_r($collection2->next());
            echo "|||||||||||||||<br/>";
        }
    }

}
