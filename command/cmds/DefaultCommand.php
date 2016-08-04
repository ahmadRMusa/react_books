<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 4:02 PM
 */

namespace command;

use controller\Request;

/**
 * Class DefaultCommand
 * @package command
 *
 * Concrete commands calls business logic and send databack to view layer
 *
 */
class DefaultCommand extends Command
{
    protected function doExecute(Request $request)
    {
        // TODO: Implement doExecute() method.

    }
}