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
        echo '<p>no book currently available!</p>';
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

function display_cart($cart, $change = true, $images = 1)
{

    $bgcolor = "#cccccc";
    $center_align = "center";

    // table header
    $colspan_iamge = $images + 1;

    echo <<< TABLE_HEADER

    <table border="0" width="100%" cellspacing="0">
    <form action="show_cart.php" method="post">
    <tr>
        <th colspan='$colspan_iamge' bgcolor='$bgcolor'>Item</th>
        <th bgcolor='$bgcolor'>Price</th>
        <th bgcolor='$bgcolor'>Quantity</th>
        <th bgcolor='$bgcolor'>Total</th>
    </tr>

TABLE_HEADER;

    // table body
    foreach ($cart as $isbn => $qty) {

        $book_detail = get_book_details($isbn);
        $book_title = $book_detail['title'];
        $book_author = $book_detail['author'];
        $book_price = number_format($book_detail['price'], 2);
        $total_price = $book_price * $qty;

        echo "<tr>";

        // display image if needed
        if ($images == true) {
            echo "<td align='left'>";
            $image_path = "images/" . $isbn . ".jpg";
            if (file_exists($image_path)) {
                $size = GetImageSize($image_path);
                // Index 0 and 1 contains respectively the width and the height of the image.
                $img_width = $size[0];
                $img_height = $size[1];
                if ($img_width > 0 && $img_height > 0) {
                    echo <<< IMAGE_DISPLAY
                    
                    <img src="$image_path" style="border: 1px solid black" width="$img_width" height="$img_height"/>

IMAGE_DISPLAY;

                } else {
                    echo "&nbsp;";
                }
            }
            echo "</td>";
        }

        // display a link to that specific item

        echo <<< SPECIFIC_ITEM

        <td align='left'><a href='show_book.php?isbn=$isbn'>$book_title</a> by $book_author</td>

SPECIFIC_ITEM;

        // price
        echo <<< SHOW_PRICE
        
        <td align='$center_align'>$book_price</td>

SHOW_PRICE;

        // can quantities when change parameter is enabled
        if ($change === true) {
            echo <<< EDITABLE_QUANTITY

        <td align="$center_align"><input type='text' name='$isbn' value='$qty' size='3'></td>

EDITABLE_QUANTITY;

        } else {
            echo <<< NON_EDITABLE_QUANTITY
        
        <td align="$center_align">$qty</td>
        
NON_EDITABLE_QUANTITY;
        }

        // total price of a specific item
        echo <<< ITEM_TOTAL_PRICE

        <td align="$center_align">$$total_price</td>\n

ITEM_TOTAL_PRICE;

    }

    // display the summary
    $summary_colspan = 2 + $images;
    $summary_items = $_SESSION['items'];
    $summary_total_price = number_format($_SESSION['total_price'], 2);

    echo <<< SUMMARY_ORDER

    <tr>
    <th colspan='$summary_colspan' bgcolor='$bgcolor'>&nbsp;</th>
    <th align='$center_align' bgcolor='$bgcolor'>$summary_items</th>
    <th align='$center_align'bgcolor='$bgcolor'>$summary_total_price</th>
    </tr>

SUMMARY_ORDER;

    // a button save order modification
    if ($change === true) {

        echo <<< SAVE_ENABLED

        <tr>
        <td colspan='$summary_colspan'>&nbsp;</td>
        <td align='$center_align'>
            <input type='hidden' name='save' value='true'>
            <input type='submit' value='save changes'>
        </td>
        </tr>

SAVE_ENABLED;


    }

    // end of the table
    echo "</form></table>";

}
