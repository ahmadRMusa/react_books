<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 12:16 AM
 */

namespace mapper;

use domain\DomainObject;
use domain\ObjectWatcher;
use base\ApplicationRegistry;

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
        $stmt = $this->getStatement($selection);
        $stmt->execute($value);
        $raw = $stmt->fetchAll();
        // transform the raw data to objects, the getCollection method comes from Persistence
        $collection = $this->factory->getCollection($raw);
        return $collection;
    }

    /**
     * @param IdentityObject $identityObject
     */
    function findOne(IdentityObject $identityObject)
    {
        $collection = $this->find($identityObject);
        return $collection->next();

    }

    /**
     * @param DomainObject $domainObject a new object that will be inserted or updated
     */
    function insert(DomainObject $domainObject)
    {
        // prepare queries
        $update_factory = $this->factory->getUpdateFactory();
        list($update_query, $values) = $update_factory->newUpdate($domainObject);
        $stmt = $this->getStatement($update_query);
        // TODO: check db query successful?
        // get the result here
        $stmt->execute($values);
        if (is_null($domainObject->getId())) {
            $domainObject->setId(self::$db_connection->lastInsertId());
        }
        $domainObject->markClean();

    }

    /**
     *
     * Perform all the events as a transaction.
     *
     */
    static function commitTransaction()
    {
        self::getConnectionObj()->beginTransaction();
        ObjectWatcher::instance()->performOperations();
        self::getConnectionObj()->commit();
    }

    /**
     * @param $statement
     * @return mixed
     */
    private function getStatement($statement)
    {
        // prepare the statement here
        if (!isset($this->statements[$statement])) {
            $this->statements[$statement] = self::getConnectionObj()->prepare($statement);
        }

        return $this->statements[$statement];

    }

    private function connect_db()
    {
        $db_info = ApplicationRegistry::getDBInfo();

        if (is_null($db_info)) {
            throw new \Exception("Database info required");
        }

        // TODO: Refactor DB info
        self::$db_connection = new \PDO('mysql:host=127.0.0.1;dbname=react_book', "root", "susie19910401");
        // self::$db_connection = new \PDO('mysql://root:susie19910401@localhost:3306/react_book');

    }

}