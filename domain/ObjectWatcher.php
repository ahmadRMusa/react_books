<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 6:45 PM
 */

namespace domain;

/**
 * Class ObjectWatcher
 * @package domain
 *
 * An identity map is simply an object whose task it is to keep track of all the objects in a system,
 * and thereby help to ensure that nothing that should be one object becomes two.
 *
 * In fact, the Identity Map itself does not prevent this from happening in any active way.
 * Its role is to manage information about objects.
 *
 * DIRTY: Objects are described as “dirty” when they have been changed since extraction from the database.
 * A dirty object is stored in the $dirty array property (via the addDirty() method)
 * until the time comes to update the database.
 *
 * NEW: a newly created object should be added to the $new array (via the addNew() method).
 * Objects in this array are scheduled for insertion into the database.
 */
class ObjectWatcher
{

    // Tracking all objects in a system via the $all property
    private $all = array();

    // Unit of Work
    private $dirty = array();
    private $new = array();
    private $delete = array();

    private static $instance = null;

    private function __construct()
    {
    }

    static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ObjectWatcher();
        }
        return self::$instance;
    }

    public function globalKey(DomainObject $object)
    {
        $key = $this->get_key(get_class($object), $object->getId());
        return $key;
    }

    public static function add(DomainObject $object)
    {
        $inst = self::instance();
        $inst->all[$inst->globalKey($object)] = $object;
    }

    public static function exists($classname, $id)
    {
        $inst = self::instance();
        $key = self::get_key($classname, $id);
        if (isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        return null;
    }

    // Unit of Work

    public static function addDelete(DomainObject $object)
    {
        $inst = self::instance();
        $inst->delete[$inst->globalKey($object)] = $object;
    }

    public static function addDirty(DomainObject $object)
    {
        $inst = self::instance();
        if (!in_array($object, $inst->new, true)) {
            $inst->dirty[$inst->globalKey($object)] = $object;
        }
    }

    public static function addNew(DomainObject $object)
    {
        $inst = self::instance();
        // we don't yet have an id now, have no way and no need to check
        $inst->new[] = $object;
    }

    public static function addClean(DomainObject $object)
    {
        $inst = self::instance();
        unset($inst->delete[$inst->globalKey($object)]);
        unset($inst->dirty[$inst->globalKey($object)]);
        // remove the object from new array since it no longer need to be or already have been inserted
        $inst->new = array_filter($inst->new,
            function ($a) use ($object) {
                return !($a === $object);
            });
    }

    /**
     * Transaction operations
     */
    public function performOperations()
    {
        foreach ($this->dirty as $key => $obj) {
            $obj->finder()->insert($obj);
        }

        foreach ($this->new as $key => $obj) {
            $obj->finder()->insert($obj);
        }

        $this->dirty = array();
        $this->new = array();
    }

    // Helper functions

    /**
     * @param $classname
     * @param $id
     * @return string
     *
     * concatenate the name of the object’s class with its table ID
     *
     */
    private function get_key($classname, $id)
    {
        return "{$classname}.{$id}";
    }


}