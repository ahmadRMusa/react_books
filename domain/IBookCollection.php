<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 5:07 PM
 */
namespace domain;

/**
 * Interface IBookCollection
 * @package domain
 *
 * decouple domain and mapper
 */
interface IBookCollection extends \Iterator
{
    function add(DomainObject $object);
}