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
     * @param array $array raw data get from database query
     * @return Book
     */

    public function createObject(array $array)
    {
        $old = $this->getFromMap($array['id']);

        if (!is_null($old)) {
            return $old;
        }

        $obj = $this->doCreateObject($array);
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


}