<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 3:08 PM
 */

namespace controller;

use base\ApplicationRegistry;
use command\CommandResolver;

class Controller
{

    private $applicationHelper;

    private function _construct()
    {
    }

    static function run()
    {
        $instance = new Controller();
        $instance->init();
        $instance->handleRequest();
    }

    function init()
    {
        $this->applicationHelper = ApplicationHelper::instance();
        $this->applicationHelper->init();
    }

    function handleRequest()
    {
        $request = ApplicationRegistry::getRequest();
        $cmd_r = new CommandResolver();
        $cmd = $cmd_r->getCommand($request);
        $cmd->execute($request);
    }

}