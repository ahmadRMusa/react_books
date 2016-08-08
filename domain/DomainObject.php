<?php


/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:37 AM
 */
namespace domain;

abstract class DomainObject
{

    private $id = null;

    // db-obj field mapping
    protected $mapping = null;

    /**
     * DomainObject constructor.
     * @param null $id
     * @param bool $shouldPersist this parameter indicates that if we should persist a new created object,
     * maybe this object is just for test usage or we are just query it
     *
     * The constructor method marks the current object as new (by calling markNew())
     * if no $id property has been passed to it
     */
    public function __construct($shouldPersist = true, $id = null)
    {
        if (is_null($id) && $shouldPersist) {
            $this->markNew();
        } else {
            $this->id = $id;
        }
    }

    /**
     * @param $obj_field_name field name of the domain object
     * @return mixed corresponding column name in database
     *
     */
    abstract public function getColumnName($obj_field_name);

    /**
     * @return mixed
     *
     * initialize mapping
     */
    abstract protected function initMapping();

    public function getMappingArray()
    {
        return $this->mapping;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param $type
     * @return mixed
     *
     *
     */
    // TODO: what should this be?
    // TODO: Now this method is in class PersistenceFactory, what is the relationship here?
    // TODO: Search for getCollection and figure out what happened to this?
    public static function getCollection($type)
    {
        if (is_null($type)) {
            return HelperFactory::getCollection(get_called_class());
        }
        return HelperFactory::getCollection($type);
    }

    /**
     * @return mixed
     *
     */
    public function collection()
    {
        return self::getCollection(get_class($this));
    }

    // Unit of Work
    public function markNew()
    {
        ObjectWatcher::addNew($this);
    }

    public function markDeleted()
    {
        ObjectWatcher::addDelete($this);
    }

    public function markDirty()
    {
        ObjectWatcher::addDirty($this);
    }

    public function markClean()
    {
        ObjectWatcher::addClean($this);
    }

    public function finder()
    {
        // Returns the name of the class of an object
        return self::getFinder(get_class($this));
    }

    public function getFinder($type = null)
    {
        if (is_null($type)) {
            // the "Late Static Binding" class name
            return HelperFactory::getFinder(get_called_class());
        }

        return HelperFactory::getFinder($type);
    }


}