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

// TODO: Admin user get different view
if (false) {

} else {
    $url = "show_cart.php";
    $title = "Add " . $book['title'] . " to Cart";
    $query_string = array(
        'new_item' => $isbn
    );
    display_hyperlink_button($url, $title, $query_string);
}




