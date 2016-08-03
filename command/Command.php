<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 3:48 PM
 */

namespace command;

use controller\Request;

abstract class Command
{
    private static $STATUS_STRINGS = array(
        'CMD_DEFAULT' => 0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3
    );

    // By declaring the constructor method final, I make it impossible for a child class to override it.
    // No Command class, therefore, will ever require arguments to its constructor.
    final function __construct()
    {
    }

    public function execute(Request $request)
    {
        $this->doExecute($request);
    }

    abstract protected function doExecute(Request $request);

}