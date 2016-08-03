<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 6:44 PM
 */

namespace controller;

use command\DefaultCommand;

class AppController
{
    private static $base_cmd = null;
    private static $default_cmd = null;
    private $controller_map;
    private $invoked = array();

    function __construct(ControllerMap $map)
    {
        $this->controller_map = $map;
        if (is_null(self::$base_cmd)) {
            self::$base_cmd = new \ReflectionClass("\\command\\Command");
            self::$default_cmd = new DefaultCommand();
        }

    }

    function reset()
    {
        $this->invoked = array();
    }

    function getView(Request $req)
    {

    }

    function getCommand(Request $req)
    {

    }

    function resolveCommand($cmd)
    {
        
    }

    private function getForward(Request $req)
    {


    }

    private function getResource(Request $req, $res)
    {

    }

}