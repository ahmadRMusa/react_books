<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:26 PM
 */
namespace mapper;

use \domain\DomainObject;
use \mapper\DomainObjectFactory;

abstract class Collection implements \Iterator
{
    protected $dof;
    // mark the index
    protected $total = 0;
    // raw data get from database query, an associative array that which id is the key
    protected $raw = array();

    private $result;
    private $pointer = 0;
    // array that saves all the initiated objects
    private $objects = array();

    /**
     * Collection constructor.
     * @param array|null $raw
     * @param \DomainObjectFactory $dof
     *
     */
    function __construct(array $raw = null, DomainObjectFactory $dof)
    {
        if (!is_null($raw) && !is_null($dof)) {
            $this - $raw = $raw;
            $this->total = count($raw);
        }

        $this->$dof = $dof;

    }

    // delegation
    abstract function targetClass();

    // lazy load
    protected function notifyAccess()
    {
    }


    // implement method from domain model interface
    function add(DomainObject $object)
    {
        // type checking
        $class = $this->targetClass();
        if (!($object instanceof $class)) {
            throw new Exception("This is a {$class} collection!");
        }

        $this->notifyAccess();

        // add a new object to collection
        $this->objects[$this->total] = $object;
        $this->total++;

    }

    private function getRow($num)
    {

        $this->notifyAccess();

        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->dof->createObject($this->raw[num]);
            return $this->objects[$num];
        }

    }

    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @return mixed|null
     *
     * get current row
     */
    public function current()
    {
        return $this->getRow($this->pointer);
    }

    /**
     * @return int
     *
     * get current position
     */
    public function key()
    {
        return $this->pointer;
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $row = $this->getRow($this->pointer);
        if ($row) {
            $this->pointer++;
        }

        /**
         * TODO: How can we use next() method in a while loop as a end loop condition? Or should we return anything here?
         */
        return $row;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return (!is_null($this->current()));
    }


}