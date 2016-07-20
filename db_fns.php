<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:06 PM
 */

/**
 * @param $result
 * get result from database and transform it to an index array
 *
 */
function db_result_to_array($result)
{
    $res_array = array();

    for ($count = 0; $row = $result->fetch_assoc(); $count++) {
        $res_array[$count] = $row;
    }

    return $res_array;
}

/**
 * @return mysqli
 * @throws Exception
 *
 * db connection
 *
 */
function db_connect()
{
    $servername = "localhost";
    $username = "root";
    $password = "susie19910401";
    $dbname = "react_book";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {

        // TODO: will not stop when there is something wrong?
        throw new Exception('Could not connect to database server');
    }

    return $conn;
}