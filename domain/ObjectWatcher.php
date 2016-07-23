<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 6:45 PM
 */

namespace domain;

use \domain\DomainObject;

/**
 * Class ObjectWatcher
 * @package domain
 *
 * An identity map is simply an object whose task it is to keep track of all the objects in a system,
 * and thereby help to ensure that nothing that should be one object becomes two.
 *
 * In fact, the Identity Map itself does not prevent this from happening in any active way.
 * Its role is to manage information about objects
 */
class ObjectWatcher
{

    private $all = array();
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
        $key = get_key(get_class($object), $object->getId());
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
        $key = get_key($classname, $id);
        if (isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        return null;
    }

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