<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/24/16
 * Time: 8:21 PM
 */

namespace mapper;

use domain\Book;
use \domain\DomainObject;

class BookUpdateFactory extends UpdateFactory
{

    function newUpdate(DomainObject $book)
    {
        $this->doUpdate($book);
    }

    private function doUpdate(Book $book)
    {
        $isbn = $book->getIsbn();
        $cond = null;
        // TODO: we need to check if isbn has already exists then get the $cond
        if (usedIsbn($isbn)) {
            $cond['isbn'] = $isbn;
        }

        $values['title'] = $book->getTitle();
        $values['author'] = $book->getAuthor();
        $values['price'] = $book->getPrice();
        // More fields here

        return $this->buildStatement("Book", $values, $cond);

    }

    // TODO: where should I put the check code?
    private function usedIsbn($isbn)
    {

    }

}