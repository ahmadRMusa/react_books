<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/4/16
 * Time: 8:42 PM
 */
namespace command;

use controller\Request;

class IndexCommand extends Command
{

    public function doExecute(Request $request)
    {
        if (true) {
            $request->addFeedback(array("msg", "index error! forwarding..."));
            return self::reformatStatus('CMD_ERROR');
        } else {
            // return self::reformatStatus('CMD_ERROR');
        }
    }

}