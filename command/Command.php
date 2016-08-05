<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 3:48 PM
 */

namespace command;

use controller\Request;

/**
 * Class Command
 * @package command
 *
 * Commands are a kind of relay station: they should interpret a request, call into the domain
 * to juggle some objects, and then lodge data for the presentation layer.
 *
 */
abstract class Command
{
    private static $STATUS_STRINGS = array(
        'CMD_DEFAULT' => 0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3
    );

    private $status = 0;

    // By declaring the constructor method final, I make it impossible for a child class to override it.
    // No Command class, therefore, will ever require arguments to its constructor.
    final function __construct()
    {
    }

    public function getStatus()
    {
        return $this->status;
    }

    public static function reformatStatus($status = 'CMD_DEFAULT')
    {
        if ($status == null || $status == "") {
            $status = 'CMD_DEFAULT';
        }

        if (isset(self::$STATUS_STRINGS[$status])) {
            return self::$STATUS_STRINGS[$status];
        }

        throw new \Exception("Unknown status {$status}");
    }

    /**
     * @param Request $request
     *
     * This method will try to update the current Command Object in the Request object,
     * which later we can get by method getLastCommand();
     *
     * So now the Request object has the result of the last command (by status)
     * and saves the last Command Object
     *
     */
    public function execute(Request $request)
    {
        // set the status
        $this->status = $this->doExecute($request);
        // save this command, next time it becomes the previous command
        $request->setCommand($this);
    }

    abstract protected function doExecute(Request $request);

}