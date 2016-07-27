<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 6:30 PM
 *
 * A normal instance of field usually contains an comps array, which is a condition for Identity Object
 */
namespace mapper;

class Field
{
    protected $name = null;
    protected $operator = null;
    protected $comps = array();
    protected $incomplete = false;

    // sets up the field name (age, for example)
    public function __construct($name)
    {
        $this->name = $name;
    }

    // add the operator and the value for the test
    // (> 40, for example) and add to the $comps property
    public function addTest($operator, $value)
    {
        $this->comps[] = array('name' => $this->name, 'operator' => $operator, 'value' => $value);
    }

    // comps is an array so that we can test one field in more than one way
    public function getComps()
    {
        return $this->comps;
    }

    // if $comps does not contain elements, then we have comparison data and this field
    // is not ready to be used in a query
    public function isIncomplete()
    {
        return empty($this->comps);
    }

}