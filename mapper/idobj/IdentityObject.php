<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 6:42 PM
 */
namespace mapper;

class IdentityObject
{
    // an field instance, we will add condition to it later
    protected $current_field = null;
    // associative array, key - field name,
    // value - an Field instance with which we can add comparison condition later
    protected $fields = array();
    // check valid fields
    private $enforce = array();

    function __construct($field = null, array $enforce = null)
    {
        if (!is_null($enforce)) {
            $this->enforce = $enforce;
        }

        if (!is_null($field)) {
            $this->field($field);
        }

    }

    /**
     * @return array an array of valid fields
     */
    public function getObjectFields()
    {
        return $this->enforce;
    }

    /**
     * @param $field_name
     * @return $this
     * @throws \Exception
     *
     * create a new field to query
     */
    public function field($field_name)
    {
        if (!$this->isFieldEmpty() && $this->current_field->isIncomplete()) {
            throw new \Exception("Incomplete Field");
        }

        $this->enforceField($field_name);

        if (isset($this->fields[$field_name])) {
            $this->current_field = $this->fields[$field_name];
        } else {
            $this->current_field = new Field($field_name);
            $this->fields[$field_name] = $this->current_field;
        }

        // we can operate on the same object later, add conditions
        return $this;

    }

    /**
     * @return array all the conditions in this IdentityObject,
     * which is in the form of array('name' => $this->name, 'operator' => $operator, 'value' => $value);
     *
     */
    public function getComps()
    {
        $comparisons = array();
        foreach ($this->fields as $field) {
            $comparisons = array_merge($comparisons, $field->getComps());
        }

        return $comparisons;
    }

    public function eq($value)
    {
        return $this->operator("=", $value);

    }

    public function lt($value)
    {
        return $this->operator("<", $value);
    }

    public function gt($value)
    {
        return $this->operator(">", $value);
    }

    public function isFieldEmpty()
    {
        return empty($this->fields);
    }

    /**
     * @param $field_name
     * @throws \Exception
     *
     * check if a given field name is legal
     */
    private function enforceField($field_name)
    {
        if (!in_array($field_name, $this->enforce) && !empty($this->enforce)) {
            $force_list = implode(', ', $this->enforce);
            throw new \Exception("{$field_name} is not a legal field {$force_list}");
        }
    }

    /**
     * @param $symbol
     * @param $value
     * @return $this so we can add more conditions ( more fields with conditions
     * @throws \Exception
     *
     * add conditions
     */
    private function operator($symbol, $value)
    {
        if ($this->isFieldEmpty()) {
            throw new \Exception("no object field defined");
        }

        $this->current_field->addTest($symbol, $value);

        return $this;

    }

}