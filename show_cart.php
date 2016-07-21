<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/20/16
 * Time: 1:41 PM
 */

/**
 *
 * TODO: BUG here, when refresh this page, you will purchase same item again
 *
 * TODO: Add to cart without going to this page
 *
 *
 */
require_once('util_lib.php');

session_start();

// get isbn
@$new_item = $_GET['new_item'];

// if we got the new item, update the shopping cart info in session
if ($new_item) {

    // init a new session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
        $_SESSION['items'] = 0;
        $_SESSION['total_price'] = 0.00;
    }

    // update info about this new item
    if (isset($_SESSION['cart'][$new_item])) {
        // ordered before
        $_SESSION['cart'][$new_item]++;
    } else {
        // new item to the cart
        $_SESSION['cart'][$new_item] = 1;
    }

    $_SESSION['total_price'] = calculate_total_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);

}

// if user update the order, update session
if (isset($_POST['save'])) {
    foreach ($_SESSION['cart'] as $isbn => $qty) {
        if (intval($_POST[$isbn]) === 0) {
            unset($_SESSION['cart'][$isbn]);
        } else {
            $_SESSION['cart'][$isbn] = $_POST[$isbn];
        }
    }

    $_SESSION['total_price'] = calculate_total_price($_SESSION['cart']);
    $_SESSION['items'] = calculate_items($_SESSION['cart']);
}

// TODO: Users can change the quantity and save
if (isset($_POST['save'])) {

    // recalculate shopping cart

}

do_html_header();

// if there is a cart and the cart is not empty
if ($_SESSION['cart'] && array_count_values($_SESSION['cart'])) {
    display_cart($_SESSION['cart']);
} else {
    echo "<p>There is nothing in your shopping cart!</p>";
}

// continue on shopping in the previous directory


if ($new_item) {
    $detail = get_book_details($new_item);
    if ($detail['catid']) {
        $url = "show_cat.php";
        $query_string = array('catid' => $detail['catid']);
        display_hyperlink_button($url, 'Continue Shopping', $query_string);
    }
} else {
    $url = "index.php";
    display_hyperlink_button($url, 'Continue Shopping');
}

display_hyperlink_button('checkout.php', 'Place your Order');



