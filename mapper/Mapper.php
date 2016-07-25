<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 3:01 PM
 */

namespace mapper;

use \domain\DomainObject;


abstract class Mapper
{
    function __construct()
    {
        // get db connection
    }

}