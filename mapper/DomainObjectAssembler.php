<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 12:16 AM
 */

namespace mapper;

use domain\DomainObject;

/**
 * Class DomainObjectAssembler
 * @package mapper
 *
 * Warriors of the Night! Assemble!
 */
class DomainObjectAssembler
{

    private $factory;

    private $statements = array();

    protected static $db_connection = null;

    function __construct(PersistenceFactory $factory)
    {
        $this->factory = $factory;

        if (!isset(self::$db_connection)) {
            self::connect_db();
        }
    }

    public static function getConnectionObj()
    {
        if (!isset(self::$db_connection)) {
            self::connect_db();
        }

        return self::$db_connection;
    }

    /**
     * @param IdentityObject $identityObject
     * @return mixed
     *
     */
    function find(IdentityObject $identityObject)
    {
        $selection_factory = $this->factory->getSelectionFactory();
        list($selection, $value) = $selection_factory->newSelection($identityObject);
        $stmt = $this->getStatement($selection, $value);
        $stmt->execute($value);
        $raw = $stmt->fetchAll();
        $collection = $this->factory->getCollection($raw);
        return $collection;
    }

    /**
     * @param IdentityObject $identityObject
     */
    function findOne(IdentityObject $identityObject)
    {
        $collection = $this->find($identityObject);

    }

    function insert(DomainObject $domainObject)
    {
        $update_factory = $this->factory->getUpdateFactory();
        list($update_query, $value) = $update_factory->newUpdate($domainObject);
        $stmt = $this->getStatement($update_query);

    }

    /**
     * @param $statement
     * @param $values
     * @return mixed
     */
    private function getStatement($statement, $values)
    {
        // prepare the statement here
        if (!isset($this->statements[$statement])) {
            $this->statements[$statement] = self::getConnectionObj()->prepare($statement);
        }

        return $this->statements[$statement];

    }

    private function connect_db()
    {
        $db_info = \ApplicationRegistry::getDBInfo();

        if (is_null($db_info)) {
            throw new \Exception("Database info required");
        }

        // TODO: Refactor DB info
        self::$db_connection = new \PDO('mysql:host=localhost;dbname=react_book', "root", "susie19910401");

    }

    private function getTypeString($values)
    {
        // TODO: check valid and blob?
        $types = array('integer' => 'i', "double" => "d", "string" => "s");
        $type_str = "";
        foreach ($values as $value) {
            $type_str = $type_str . $types[gettype($value)];
        }

        return $type_str;

    }

}