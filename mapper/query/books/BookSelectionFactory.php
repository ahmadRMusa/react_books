<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 1:24 AM
 */

namespace mapper;

class BookSelectionFactory extends SelectionFactory
{
    function newSelection(IdentityObject $identityObject)
    {
        $fields = implode(',', $identityObject->getObjectFields());
        $core = "SELECT {$fields} FROM books";
        list($where, $values) = $this->buildSelection($identityObject);
        return array($core . " " . $where, $values);
    }

}