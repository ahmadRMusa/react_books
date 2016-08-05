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

    /**
     *
     * Based on command, render a view
     *
     */
    function handleRequest()
    {
        $request = ApplicationRegistry::getRequest();
        // this is for the old front controller
        // $cmd_r = new CommandResolver();
        // $cmd = $cmd_r->getCommand($request);
        // $cmd->execute($request);
        // TODO: Controller Map
        $app_ctrl = ApplicationRegistry::getAppController();

        /**
         * inside, will set the results(status) of the last command
         * in the xml config file, if a status node saves a forward element,
         * then it cannot save a view element, vise versa.
         *
         * so the workflow is like the following
         *
         * The get command will return a command object which is like Locating the
         * command in the xml file.
         *
         * Then Execute the command will update the command object in the Request,
         * and it will get the result of execute this command which will return a
         * status code.
         *
         * If the result leads to a forward command, the while loop will continue,
         * and if it is not, which means it MUST be a view, then the invokeView
         * will present the view.
         *
         * It is just like a request can be processed by a chain of actions(commands)
         */
        while ($cmd = $app_ctrl->getCommand($request)) {
            // TODO: Why execute?
            $cmd->execute($request);
        }

        // after all the command(action) chain, presents the result
        $this->invokeView($app_ctrl->getView($request));
    }

    private function invokeView($target)
    {
        include("../view/{$target}View.php");
    }

}