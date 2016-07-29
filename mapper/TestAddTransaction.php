<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/28/16
 * Time: 2:48 AM
 */

namespace mapper;

use domain\Book;
use domain\ObjectWatcher;

class TestAddTransaction
{

    public function runTest()
    {

        $object1 = new Book(null, '22135', 'java', 'how to advance java', 1, 44.2, 'fantastic good book', true);
        $object2 = new Book(null, '25135', 'advance', 'how to advance java', 1, 44.2, 'fantastic good book', true);
        $object3 = new Book(null, '26135', 'how', 'how to advance java', 1, 44.2, 'fantastic good book', true);

        // ObjectWatcher::instance()->performOperations();
        DomainObjectAssembler::commitTransaction();

    }

}