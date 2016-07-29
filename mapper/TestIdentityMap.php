<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/28/16
 * Time: 7:54 PM
 */

namespace mapper;


class TestIdentityMap
{

    public function runTest()
    {
        $factory = PersistenceFactory::getFactory("Book");
        $idobj = $factory->getIdentityObject()->field('author')->eq('jie');
        $finder = PersistenceFactory::getFinder("Book");
        $collection = $finder->find($idobj);
        $collection2 = $finder->find($idobj);

        // should get from collection cache directly
        print_r($collection->current());
        echo "<br/>";
        echo "<br/>";
        print_r($collection->current());
        echo "<br/>";
        echo "<br/>";

        // different collection should still get object from identity map
        while ($collection->current()) {
            print_r($collection->next());
            echo "<br/>";
            echo "<br/>";
        }

        echo "<br/>";
        echo "<br/>";

        // we changed some information in collection2
        while ($collection2->current()) {
            $collection2->current()->setAuthor('change to sb');
            print_r($collection2->next());
            echo "<br/>";
            echo "<br/>";
        }

        echo "<br/>";
        echo "<br/>";

        // we expect collection1 should have the same information?
        $collection->rewind();
        while ($collection->current()) {
            print_r($collection->next());
            echo "<br/>";
            echo "<br/>";
        }

        echo "<br/>";
        echo "<br/>";


    }

}