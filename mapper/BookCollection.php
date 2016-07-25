<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 4:37 PM
 */

namespace mapper;

/**
 * Class BookCollection
 *
 * TODO: IBookCollection no need for namespace?
 */
class BookCollection extends Collection implements IBookCollection
{
    function targetClass()
    {
        // TODO: correct implementation? return a string?
        return "\\domain\\Book";
    }
}