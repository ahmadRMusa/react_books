<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 4:36 PM
 */

namespace base\exception;


class AppException extends \Exception
{
    function __construct($message, $code, Exception $previous)
    {
        parent::__construct($message, $code, $previous);
    }
}