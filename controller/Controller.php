<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 3:08 PM
 */

namespace controller;

use base\ApplicationRegistry;

/**
 * Class Controller
 * @package controller
 *
 * TODO: the start of the app?
 *
 */
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
        // this is for the old front controller
        // $cmd_r = new CommandResolver();
        // $cmd = $cmd_r->getCommand($request);
        // $cmd->execute($request);
        // TODO: Controller Map
        $app_ctrl = ApplicationRegistry::getAppController();

        // analyze all the forward chain
        while ($cmd = $app_ctrl->getCommand($request)) {
            // TODO: Why execute?
            $cmd->execute($request);
        }

        $this->invokeView($app_ctrl->getView($request));
    }

    private function invokeView($target)
    {
        include("view/{$target}.php");
    }

}