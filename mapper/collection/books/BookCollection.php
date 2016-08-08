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
 * BookCollection will use Collection's constructor to get a new Collection
 *
 */
class BookCollection extends Collection implements IBookCollection
{
    function targetClass()
    {
        // TODO: correct implementation? return a string? The code has ever arrived here?
        return "\\domain\\Book";
    }
}