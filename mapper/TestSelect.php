<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 2:29 AM
 */

namespace mapper;


class TestSelect
{

    public function runTest()
    {
        // $factory here is the BookPersistenceFactory
        $factory = PersistenceFactory::getFactory("Book");
        $idobj = $factory->getIdentityObject()->field('author')->eq('jie');
        // $finder is a domian object assembler
        $finder = PersistenceFactory::getFinder("Book");
        $collection = $finder->find($idobj);
        $collection2 = $finder->find($idobj);
        // output result
        while ($collection->current()) {
            print_r($collection->next());
            echo "|||||||||||||||<br/>";
        }

        echo "<br/>";
        echo "<br/>";

        while ($collection2->current()) {
            print_r($collection2->next());
            echo "|||||||||||||||<br/>";
        }
    }

}