<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 6:15 PM
 */

namespace controller;

// TODO: Where can I get this class?
class ControllerMap
{

    // The $forwardMap and $viewMap arrays are both two-dimensional,
    // supporting combinations of commands and statuses.
    private $viewMap = null;
    private $forwardMap = null;
    private $classrootMap = null;
    
    function addClassroot($command, $classroot)
    {
        $this->classrootMap[$command] = $classroot;
    }

    function getClassroot($command)
    {
        if (isset($this->classrootMap[$command])) {
            return $this->classrootMap[$command];
        }

        // if command is not found in classrootmap, return the command itself.
        return $command;
    }

    function addView($view, $command = 'default', $status = 0)
    {
        $this->viewMap[$command][$status] = $view;
    }

    function getView($command, $status)
    {
        if (isset($this->viewMap[$command][$status])) {
            return $this->viewMap[$command][$status];
        }
        return null;
    }

    function addForward($command, $status = 0, $newCommand)
    {
        $this->forwardMap[$command][$status] = $newCommand;
    }

    function getForward($command, $status)
    {
        if (isset($this->forwardMap[$command][$status])) {
            return $this->forwardMap[$command][$status];
        }
        return null;
    }

}