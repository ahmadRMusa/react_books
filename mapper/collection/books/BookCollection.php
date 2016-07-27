<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 4:37 PM
 */

namespace mapper;

use domain\IBookCollection;

/**
 * Class BookCollection
 *
 */
class BookCollection extends Collection implements IBookCollection
{
    function __construct()
    {
        echo "test";
    }

    function targetClass()
    {
        // TODO: correct implementation? return a string?
        return "\\domain\\Book";
    }
}