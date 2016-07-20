<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 6:27 PM
 */

require_once('util_lib.php');

session_start();

$isbn = $_GET['isbn'];

$book = get_book_details($isbn);

display_book_details($book);



