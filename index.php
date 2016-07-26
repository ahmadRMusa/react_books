<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:24 PM
 */

// set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);

require_once('util_lib.php');
require_once 'base/NamespaceRegistry.php';
require_once 'vendor/autoload.php';

$autoload = new NamespaceRegistry(__DIR__);

$autoload->addNamespace('\\', '');

$autoload->addNamespace('mapper', 'mapper/');
$autoload->addNamespace('mapper', 'mapper/collection');
$autoload->addNamespace('mapper', 'mapper/collection/books');

$autoload->addNamespace('domain', 'domain/');

$autoload->register();


$cat_arr = get_categories();

display_categories($cat_arr);

do_html_url('login.php', 'Go to Login Page');

$test = new mapper\TempTest();
// $test->runTest();

$bc = new mapper\BookCollection();




