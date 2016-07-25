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

    protected static $db_connection;

    function __construct(PersistenceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param IdentityObject $identityObject
     */
    function find(IdentityObject $identityObject)
    {
        $selection_factory = $this->factory->getSelectionFactory();
        list($selection, $value) = $selection_factory->newSelection($identityObject);
        $stmt = $this->getStatement($selection);
        // get raw data


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
     * @param $str
     *
     * TODO: prepare statement
     */
    private function getStatement($str)
    {
        // prepare the statement here
    }

}