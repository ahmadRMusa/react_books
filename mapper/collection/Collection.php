<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:26 PM
 */
namespace mapper;

use \domain\DomainObject;

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
     * @param \mapper\DomainObjectFactory $dof we now use Domain Object Factory to create a new object
     *
     * this constructor may have two functionalities
     * 1. wrap the raw data to a collection object so that we can operate on the raw data
     * 2. get a new empty collection for domain layer, and domain layer can add objects to it
     */
    function __construct(array $raw = null, DomainObjectFactory $dof)
    {
        if (!is_null($raw) && !is_null($dof)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }

        $this->dof = $dof;

    }

    /**
     * @return mixed
     *
     * delegation
     */
    abstract function targetClass();

    // lazy load
    protected function notifyAccess()
    {
    }


    /**
     * @param DomainObject $object
     * @throws \Exception
     *
     * implement method from domain model interface
     *
     * If no arguments were passed to the constructor, the class starts out empty,
     * though note that there is the add() method for adding to the collection.
     */
    function add(DomainObject $object)
    {
        // type checking
        $class = $this->targetClass();
        if (!($object instanceof $class)) {
            throw new \Exception("This is a {$class} collection!");
        }

        $this->notifyAccess();

        // TODO: Object watcher?
        // add a new object to collection
        $this->objects[$this->total] = $object;
        $this->total++;

    }

    /**
     * @param $num
     * @return mixed|null
     *
     * Note: Collection and Identity Map are different thing. You can have multiple Collections even with
     * the same content, but you can only have one Identity Map.
     *
     * All the objects are references to objects in the Identity Map, since objects are passed by reference.
     *
     * Change the object in one collection will result the change of the one in another.
     *
     * So here each collection has an objects array that stores all the initialized object and once the object
     * is initialized, it will be added to Identity Map. So there are two level cache here, one is from collection
     * and the other is from Identity Map. Since objects are all passed by reference, these two level of caches
     * keep synchronized.
     *
     * In the same collection, same object will get directly from cache without even trying to call createObject(),
     * though createObject() also has cache. And same object will not be initialized twice thanks to the Identitiy map.
     *
     * So suppose there are two collections with same two objects. The first time we add a new object to the collection,
     * we need to initialize the object from raw data, which will be saved to Identity Map. So the time we add objects to
     * another collection, we do not need to initialize the object from raw data again.
     *
     * Meanwhile, if we get from the collection the first time, we need to add the new object to COLLECTION'S CACHE.
     * The second time we get data from the same collection, the object is already prepared and no need to initialize.
     */
    private function getRow($num)
    {

        $this->notifyAccess();

        if ($num >= $this->total || $num < 0) {
            return null;
        }

        // Note: Object is passed by reference. If the object changed later,
        // the corresponding value of the array will also change
        if (isset($this->objects[$num])) {

            echo "Cache: Collection::getRow() <br/>";

            return $this->objects[$num];
        }

        // 
        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->dof->createObject($this->raw[$num]);
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
     * @return mixed|null
     * return the current element if exists then move to the next element.
     * return false if pointer is now at the end of the collection
     */
    public function next()
    {
        $row = $this->getRow($this->pointer);
        if ($row) {
            $this->pointer++;

        }
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