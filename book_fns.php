<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:11 PM
 */

/**
 * @return array|bool
 * @throws Exception
 *
 * get all the categories
 *
 */
function get_categories()
{
    $conn = db_connect();
    $query = 'select catid, catname from categories';
    $result = $conn->query($query);
    if (!$result) {
        echo "get_categories wrong..";
        return false;
    }

    $num_cats = $result->num_rows;
    if ($num_cats == 0) {

        echo 'no category for now';
        return false;
    }
    $ret = db_result_to_array($result);
    return $ret;

}

/**
 * @param $catid
 * @return bool
 * @throws Exception
 *
 * get the name of the category based on category id
 *
 */
function get_category_name($catid)
{
    $conn = db_connect();
    $query = "select catname from categories where catid = '" . $catid . "'";
    $result = $conn->query($query);
    if (!$result) {
        return false;
    }

    $num_cats = $result->num_rows;

    if ($num_cats == 0) {
        return false;
    }

    $row = $result->fetch_object();

    return $row->catname;
}

/**
 * @param $catid
 * @return array|bool
 * @throws Exception
 *
 *
 */
function get_books($catid)
{
    $conn = db_connect();
    $query = "select title, author,isbn from books where catid='" . $catid . "'";
    $result = $conn->query($query);

    if (!$result) {
        echo "get_books wrong";
        return false;
    }

    $num_books = $result->num_rows;

    if ($num_books === 0) {

        echo 'no books under this category for now';
        return false;
    }

    $ret = db_result_to_array($result);

    return $ret;
}

/**
 * @param $isbn
 * @return bool
 * @throws Exception
 *
 * return an associative array that contains a book's detail
 *
 */
function get_book_details($isbn)
{
    $conn = db_connect();
    $query = "select * from books where isbn='" . $isbn . "'";
    $result = $conn->query($query);

    if (!$result) {
        echo "get_book_details wrong";
        return false;
    }

    // no need to turn result to array
    return $result->fetch_assoc();
}

/**
 * @param $cart
 * @return float
 * @throws Exception
 *
 *
 */
function calculate_total_price($cart)
{
    $total_price = 0.0;

    if (is_array($cart) && array_count_values($cart)) {

        $conn = db_connect();
        foreach ($cart as $isbn => $qty) {
            $query = "select price from books where isbn='$isbn';";
            $result = $conn->query($query);
            if ($result) {
                $item = $result->fetch_assoc();
                $item_price = $item['price'] * $qty;
                $total_price += $item_price;
            }
        }

    }

    return $total_price;

}

/**
 * @param $cart
 * @return int
 *
 *
 */
function calculate_items($cart)
{
    $total_items = 0;
    if (is_array($cart) && array_count_values($cart)) {
        foreach ($cart as $isbn => $qty) {
            $total_items += $qty;
        }
    }

    return $total_items;
}