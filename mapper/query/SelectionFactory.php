<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 1:23 AM
 */

namespace mapper;

/**
 * Class SelectionFactory
 * @package mapper
 *
 * This class prepare sql query and its corresponding data.
 */
abstract class SelectionFactory
{
    abstract function newSelection(IdentityObject $identityObject);

    public function buildSelection(IdentityObject $identityObject)
    {
        if ($identityObject->isFieldEmpty()) {
            return array("", array());
        }

        $comp_strings = array();
        $values = array();

        foreach ($identityObject->getComps() as $condition) {
            $comp_strings[] = "{$condition['name']} {$condition['operator']} ?";
            $values[] = $condition['value'];
        }

        $where = " WHERE " . implode("AND ", $comp_strings);
        return array($where, $values);
    }

}