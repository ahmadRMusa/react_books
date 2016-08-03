<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 6:44 PM
 */

namespace controller;

use base\ApplicationRegistry;
use command\DefaultCommand;

class AppController
{
    private static $base_cmd = null;
    private static $default_cmd = null;
    private $controller_map;
    private $invoked = array();

    function __construct()
    {
        // TODO: Where should I get the controller map?
        $this->controller_map = ApplicationRegistry::getControllerMap();
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

    private function getForward(Request $req)
    {
        $forward = $this->getResource($req, "Forward");

        if ($forward) {
            $req->setProperty('cmd', $forward);
        }

        return $forward;

    }

    /**
     * @param Request $req
     * @return DefaultCommand|null|void
     * @throws \Exception
     *
     *
     */
    function getCommand(Request $req)
    {
        $previous = $req->getLastCommand();

        if (!$previous) {
            $cmd = $req->getProperty('cmd');
            if (is_null($cmd)) {
                $req->setProperty('cmd', 'default');
                return self::$default_cmd;
            }
        } else {
            $cmd = $this->getForward($req);
            if (is_null($cmd)) {
                return null;
            }
        }

        $cmd_obj = $this->resolveCommand('cmd');
        if (is_null($cmd_obj)) {
            throw new \Exception("Couldn't resolve {$cmd}");
        }

        // prevent circular forwarding
        $cmd_class = get_class($cmd_obj);
        if (isset($this->invoked[$cmd_class])) {
            throw new \Exception('circular forwarding');
        }

        $this->invoked[$cmd_class] = 1;
        return $cmd_obj;

    }

    function resolveCommand($cmd)
    {
        $classroot = $this->controller_map->getClassroot($cmd);
        $file_path = "command/cmds/{$classroot}.php";
        $classname = "\\command\\$classroot";
        if (file_exists($file_path)) {
            require_once($file_path);
            if (class_exists($classname)) {
                $cmd_class = new \ReflectionClass($classname);
                if ($cmd_class->isSubclassOf(self::$base_cmd)) {
                    return $cmd_class->newInstance();
                }
            }
        }

        return null;

    }

    /**
     * @param Request $req
     * @param $method
     *
     * get the name of the command from controller map
     *
     */
    private function getResource(Request $req, $method)
    {
        $cmd_str = $req->getProperty('cmd');
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();

        if (!isset($status) || !is_int($status)) {
            $status = 0;
        }

        // assemble a new method, either getView or getForward
        $acquire = "get{$method}";
        $resource = $this->controller_map->$acquire($cmd_str, $status);

        // TODO: try to get a map, but why in this sequence?
        if (is_null($resource)) {
            $resource = $this->controller_map->$acquire($cmd_str, 0);
        }

        if (is_null($resource)) {
            $resource = $this->controller_map->$acquire('default', $status);
        }

        if (is_null($resource)) {
            $resource = $this->controller_map->$acquire('default', 0);
        }

        return $resource;

    }

}