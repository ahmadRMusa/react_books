<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:24 PM
 */
require_once('util_lib.php');
require __DIR__ . '/vendor/autoload.php';

$cat_arr = get_categories();

display_categories($cat_arr);

do_html_url('login.php', 'Go to Login Page');

