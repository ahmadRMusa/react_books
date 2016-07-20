<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:36 PM
 */

/**
 * @param string $title
 */
function do_html_header($title = "html header")
{

}

function do_html_footer()
{

}

function do_html_url($url, $title)
{
    echo "<a href=" . $url . ">" . $title . "</a>";
}

/**
 * @param $url
 * @param $title
 * @param array $query_string_array
 * @param string $submit_method
 */
function display_hyperlink_button($url, $title, $query_string_array = array(), $submit_method = "GET")
{

    $query_strings = "";

    // TODO: Have a stronger type check
    if (!isset($query_string_array) && !is_array($query_string_array)) {
        echo "something wrong with your query string!";
    } else {
        foreach ($query_string_array as $key => $value) {
            $query_strings = $query_strings . "<input type='hidden' name=$key value=$value>";
        }
    }

    echo <<< BUTTON
    
    <form method="$submit_method" action="$url">
        $query_strings
        <input type="submit" value="$title">
    </form>

BUTTON;

}


function display_categories($cat_array)
{
    if (!is_array($cat_array)) {
        echo '<p>no category currently available!</p>';
        return;
    }

    // output an organized list
    echo "<ul>";

    foreach ($cat_array as $row) {
        $url = "show_cat.php?catid=" . ($row['catid']);
        $title = $row['catname'];
        echo "<li>";
        do_html_url($url, $title);
        echo "</li>";
    }

    echo "</ul>";
}

function display_books($book_array)
{

    if (!is_array($book_array)) {
        echo '<p>no books currently available!</p>';
        return;
    }

    // output an organized list
    echo "<ul>";

    // show every book under certain category
    foreach ($book_array as $row) {

        $url = "show_book.php?isbn=" . ($row['isbn']);
        $book_name = $row['title'];
        $book_author = $row['author'];
        $title = "Book name: " . $book_name . " -- Author name: " . $book_author;
        echo "<li>";
        do_html_url($url, $title);
        echo "</li>";
    }

    echo "</ul>";

}

function display_book_details($book)
{

    if (!$book) {
        echo '<p>something wrong with book!</p>';
        return;
    }

    echo "<ul>";
    foreach ($book as $key => $value) {
        echo "<li><p>" . $key . "--" . $value . "</p></li>";
    }
    echo "</ul>";

}

function display_cart($cart)
{

}