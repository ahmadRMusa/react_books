<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/4/16
 * Time: 6:45 PM
 */

namespace command;

use controller\Request;

class LoginCommand extends Command
{

    public function doExecute(Request $request)
    {
        if (true) {
            $request->addFeedback(array("msg", "show me!"));
            // return self::reformatStatus('CMD_OK');
        } else {
            // return self::reformatStatus('CMD_ERROR');
        }
    }

}