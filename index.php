<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:24 PM
 */
require_once('util_lib.php');

$cat_arr = get_categories();

display_categories($cat_arr);