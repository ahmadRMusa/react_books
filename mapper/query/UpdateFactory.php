<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 7:48 PM
 */

namespace mapper;

use domain\DomainObject;

/**
 * Class UpdateFactory
 * @package mapper
 *
 * This class prepare sql query and its corresponding data.
 *
 */
abstract class UpdateFactory
{

    abstract function newUpdate(DomainObject $book);

    /**
     * @param $table
     * @param array $fields key-value pair corresponding to field name and the its value that will be updated
     * @param array|null $conditions the conditions will be used when update an object
     * @return array an array contains two elements, one is the sql and the other is the data need to be inserted or updated
     *
     */
    protected function buildStatement($table, array $fields, array $conditions = null)
    {

        $terms = array();
        if (!is_null($conditions)) {
            $query = "UPDATE {$table} SET ";
            $query .= implode(" = ?, ", array_keys($fields)) . " = ?";
            $terms = array_values($fields);
            $cond = array();
            $query .= " WHERE ";
            foreach ($conditions as $key => $val) {
                $cond[] = "{$key} = ?";
                $terms[] = $val;
            }
            $query .= implode(" AND ", $cond);
        } else {
            $query = "INSERT INTO {$table} (";
            $query .= implode(",", array_keys($fields));
            $query .= ") VALUES (";
            foreach ($fields as $value) {
                $terms[] = $value;
                $qs[] = '?';
            }
            $query .= implode(",", $qs);
            $query .= ")";
        }

        return array($query, $terms);

    }

}