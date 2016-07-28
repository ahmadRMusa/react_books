<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:24 PM
 */

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);

require_once 'util_lib.php';
require_once 'base/NamespaceRegistry.php';
require_once 'vendor/autoload.php';
// require_once 'base/ApplicationRegistry.php';
// require_once 'base/Registry.php';

$autoload = NamespaceRegistry::getInstance(__DIR__);

// TODO: Global?
// $autoload->addNamespace('\\', '');
$autoload->addNamespace('\\', 'base/');

$autoload->addNamespace('mapper', 'mapper/');
$autoload->addNamespace('mapper', 'mapper/collection');
$autoload->addNamespace('mapper', 'mapper/collection/books');
$autoload->addNamespace('mapper', 'mapper/objcreate');
$autoload->addNamespace('mapper', 'mapper/objcreate/books');
$autoload->addNamespace('mapper', 'mapper/idobj');
$autoload->addNamespace('mapper', 'mapper/idobj/books');
$autoload->addNamespace('mapper', 'mapper/query');
$autoload->addNamespace('mapper', 'mapper/query/books');

$autoload->addNamespace('domain', 'domain/');

$autoload->register();

\ApplicationRegistry::instance();

$test = new mapper\TestSelect();
$test->runTest();


