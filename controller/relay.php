<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/4/16
 * Time: 11:19 AM
 */

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);

// TODO: Refactor this shit
require_once '../vendor/autoload.php';
require_once '../base/NamespaceRegistry.php';

use base\NamespaceRegistry;

// $autoload = NamespaceRegistry::getInstance(__DIR__);

$autoload = NamespaceRegistry::getInstance('/Users/jlou/Sites/react_books/');

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

$autoload->addNamespace('controller', 'controller/');

$autoload->addNamespace('command', 'command/');
$autoload->addNamespace('command', 'command/cmds/');
$autoload->addNamespace('command', 'command/cmds/authentication/');
$autoload->addNamespace('command', 'command/cmds/books/');

$autoload->register();

require_once '../base/Registry.php';
require_once '../base/ApplicationRegistry.php';

use controller\Controller;
use base\ApplicationRegistry;

// set 'cmd' for Request
$uri = $_SERVER['REQUEST_URI'];
$start_pos = strrpos($uri, "/") + 1;
// get rid of query string
$query_string_pos = strpos($uri, "?");
if ($query_string_pos) {
    $cmd = substr($uri, $start_pos, $query_string_pos - 4 - $start_pos);
} else {
    $end_pos = strlen($uri) - 4;
    $cmd = substr($uri, $start_pos, $end_pos - $start_pos);
}

ApplicationRegistry::getRequest()->setProperty('cmd', $cmd);

// we need to set request here

Controller::run();