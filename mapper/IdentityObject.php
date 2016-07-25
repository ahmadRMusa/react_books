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

    protected $current_field = null;
    protected $fields = array();
    private $enforce = array();

    function __construct($field = null, array $enforce = null)
    {
        if (!is_null($enforce)) {
            $this->enforce = $enforce;
        }

        if (!is_null($field)) {

        }

    }

    public function getObjectFields()
    {
        return $this->enforce;
    }

    /**
     * @param $field_name
     * @return $this
     * @throws Exception
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

        return $this;

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
     * @throws Exception
     *
     * check if a given field name is legal
     */
    private function enforceField($field_name)
    {
        if (!in_array($field_name, $this->enforce) && !empty($this->enforce)) {
            $force_list = implode(', ', $this->enforce);
            throw new Exception("{$field_name} is not a legal field {$$force_list}");
        }
    }

    private function operator($symbol, $value)
    {
        if ($this->isFieldEmpty()) {
            throw new Exception("no object field defined");
        }

        $this->current_field->addTest($symbol, $value);
        return $this;

    }

    private function getComps()
    {
        $comparisons = array();
        foreach ($this->fields as $field) {
            array_merge($comparisons, $field->getComps());
        }

        return $comparisons;
    }

}