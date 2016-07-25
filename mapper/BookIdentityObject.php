<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 7:44 PM
 */
namespace mapper;

class BookIdentityObject extends IdentityObject
{

    function __construct($field = null)
    {
        // TODO: How to lists all the attributes of an object here?
        parent::__construct($field, array('title', 'author'));
    }

}