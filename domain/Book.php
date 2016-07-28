<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 1:40 AM
 */

namespace domain;


class Book extends DomainObject
{

    // TODO: we should take care of the Unit of Work Pattern when using setters and getters here
    private $isbn;
    private $author;
    private $title;
    private $catid;
    private $price;
    private $description;

    public function __construct($id, $isbn, $author, $title, $catid, $price, $description, $shouldPersist)
    {
        parent::__construct($shouldPersist, $id);
        $this->isbn = $isbn;
        $this->author = $author;
        $this->title = $title;
        $this->catid = $catid;
        $this->price = $price;
        $this->description = $description;
        $this->initMapping();

    }

    public function getColumnName($obj_field_name)
    {
        if (is_null($this->mapping) || !is_array($this->mapping)) {
            throw new \Exception('Mapping is not initialized...');
        }

        if (!isset($this->mapping[$obj_field_name])) {
            throw new \Exception('Not Valid field name of object');
        }

        return $this->mapping[$obj_field_name];
    }

    protected function initMapping()
    {
        $this->mapping['id'] = 'book_id';
        $this->mapping['isbn'] = 'isbn';
        $this->mapping['title'] = 'title';
        $this->mapping['author'] = 'author';
        $this->mapping['price'] = 'price';
        $this->mapping['catid'] = 'catid';
        $this->mapping['description'] = 'description';
    }

    /**
     * @return mixed
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @param mixed $isbn
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;
        parent::markDirty();
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
        parent::markDirty();
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
        parent::markDirty();
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
        parent::markDirty();
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        parent::markDirty();
    }

    /**
     * @return mixed
     */
    public function getCatid()
    {
        return $this->catid;
    }

    /**
     * @param mixed $catid
     */
    public function setCatid($catid)
    {
        $this->catid = $catid;
        parent::markDirty();
    }

}