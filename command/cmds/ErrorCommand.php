<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/4/16
 * Time: 9:48 PM
 */

namespace command;

use controller\Request;

class ErrorCommand extends Command
{
    public function doExecute(Request $request)
    {
        if (true) {
            $request->addFeedback(array("msg", "show errors!"));
            return self::reformatStatus('CMD_OK');
        } else {
            // return self::reformatStatus('CMD_ERROR');
        }
    }
}