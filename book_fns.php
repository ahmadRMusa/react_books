<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:11 PM
 */

function get_categories()
{
    $conn = db_connect();
    $query = 'select catid, catname from categories';
    $result = @$conn->query($query);
    if (!$result) {
        return false;
    }

    $num_cats = @$result->num_rows;
    if ($num_cats == 0) {

        echo 'no category for now';
        return false;
    }
    $ret = db_result_to_array($result);
    return $ret;

}