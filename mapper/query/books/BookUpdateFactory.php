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

    public function newUpdate(DomainObject $book)
    {
        return $this->doUpdate($book);
    }

    private function doUpdate(Book $book)
    {
        $id = $book->getId();
        $cond = null;
        // TODO: we need to check if isbn has already exists then get the $cond
        if (!is_null($id)) {
            $cond[$book->getColumnName('id')] = $id;
        }


        $values[$book->getColumnName('isbn')] = $book->getIsbn();
        $values[$book->getColumnName('title')] = $book->getTitle();
        $values[$book->getColumnName('author')] = $book->getAuthor();
        $values[$book->getColumnName('price')] = $book->getPrice();
        $values[$book->getColumnName('catid')] = $book->getCatid();
        $values[$book->getColumnName('description')] = $book->getDescription();

        return $this->buildStatement("books", $values, $cond);

    }

}