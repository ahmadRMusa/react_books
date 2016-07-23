<?php
/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/23/16
 * Time: 12:31 AM
 */

namespace controller;

/**
 * Class Request
 * @package controller
 *
 * By centralizing request operations in one place,
 * we could, for example, apply filters to the incoming request.
 * Or, gather request parameters from somewhere other than an HTTP request,
 * allowing the application to be run from the command line or from a test script.
 *
 */
class Request
{

    private $properties;
    private $feedback = array();

    function __construct()
    {
    }

    function init()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
            return;
        }

        /**
         *
         * TODO: get more info here
         *
         * Array of arguments passed to the script. When the script is run on the command line,
         * this gives C-style access to the command line parameters.
         * When called via the GET method, this will contain the query string.
         */
        foreach ($_SERVER['argv'] as $arg) {

            // Find the position of the first occurrence of a substring in a string
            if (strpos($arg, '=')) {
                list($key, $val) = explode("=", $arg);
                $this->setProperty($key, $val);
            }
        }
    }

    function getProperty($key)
    {
        if (isset($this->properties[$key])) {
            return $this->properties[$key];
        }
        return null;
    }

    function setProperty($key, $val)
    {
        $this->properties[$key] = $val;
    }

    function addFeedback($msg)
    {
        array_push($this->feedback, $msg);
    }

    function getFeedback()
    {
        return $this->feedback;
    }

    function getFeedbackString($separator = "\n")
    {
        return implode($separator, $this->feedback);
    }


}