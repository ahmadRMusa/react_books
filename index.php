<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/19/16
 * Time: 4:24 PM
 */

// set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__);

require_once('util_lib.php');

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($classname) {

    // mapper\ namespace for the on loading class
    // TODO: Should not hard coded here
    $prefix = 'mapper\\';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . "/";

    // does the class use the namespace prefix?
    $len = strlen($prefix);
    if (strncmp($prefix, $classname, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // replace namespace separators with directory separators in the class name, append with .php
    $file = $base_dir . str_replace('\\', '/', $classname) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require_once $file;
    }

});

$cat_arr = get_categories();

display_categories($cat_arr);

do_html_url('login.php', 'Go to Login Page');

$test = new mapper\TempTest();
$test->runTest();




