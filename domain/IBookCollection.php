<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 5:07 PM
 */
use \domain\DomainObject;

interface IBookCollection extends \Iterator
{
    function add(DomainObject $object);
}