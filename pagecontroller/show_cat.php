<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:41 PM
 */

require_once('util_lib.php');

session_start();

$catid = $_GET['catid'];

# no db connection?
$catname = get_category_name($catid);

echo $catname;

$book_array = get_books($catid);

display_books($book_array);

// TODO: if logged in as admin

