<?php

/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/3/16
 * Time: 11:51 PM
 */
namespace business;

use mapper\PersistenceFactory;

class BooksManager
{

    public function listAllBooks()
    {

    }

    /**
     * @param array $condition associative array key is the filed and value is the value
     *
     * find a book with some limitation
     */
    public function getSpecificBook(array $conditions)
    {
        $factory = PersistenceFactory::getFactory("Book");
        $finder = PersistenceFactory::getFinder("Book");
        // get an identity object from condition
        $idobj = $factory->getIdentityObject();
        foreach ($conditions as $condition => $value) {
            $idobj->field($condition)->eq($value);
        }
        // $idobj = $factory->getIdentityObject()->field('author')->eq('jie');

        $collection = $finder->find($idobj);
        $res = array();
        while ($collection->current()) {
            array_push($res, $collection->next());
        }
        return $res;
    }


}