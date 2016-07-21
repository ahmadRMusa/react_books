<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/21/16
 * Time: 3:23 PM
 */

require_once('vendor/autoload.php');

$mustache = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__) . '/templates')
));

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === 'jie' && $password === 'jie') {
    $tpl = $mustache->loadTemplate('admin_page');
    echo $tpl->render();
} else {
    $tpl = $mustache->loadTemplate('login');
    echo $tpl->render();
}
