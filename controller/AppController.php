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

    /**
     * @param Request $req
     *
     * get a view from viewMap array in ControllerMap
     *
     */
    function getView(Request $req)
    {
        $view = $this->getResource($req, "View");
        return $view;
    }

    /**
     * @param Request $req
     *
     * get a view from $forwardMap array in ControllerMap
     *
     */
    function getCommand(Request $req)
    {

    }

    function resolveCommand($cmd)
    {

    }

    private function getForward(Request $req)
    {
        $forward = $this->getResource($req, "Forward");

        if ($forward) {
            // TODO: Why set a property here?
            $req->setProperty('cmd', $forward);
        }

        return $forward;

    }

    private function getResource(Request $req, $res)
    {

    }

}