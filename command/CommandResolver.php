<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/2/16
 * Time: 3:36 PM
 */

namespace command;

use controller\Request;

/**
 * Class CommandResolver
 * @package command
 *
 * @Deprecated
 * Replaced by application controller
 *
 */
class CommandResolver
{

    private static $base_cmd = null;
    private static $default_cmd = null;

    function __construct()
    {
        if (is_null(self::$base_cmd)) {
            // TODO: what is the return value?
            // TODO: the right way to refer to the class?
            self::$base_cmd = new \ReflectionClass("\\command\\Command");
            self::$default_cmd = new DefaultCommand();
        }
    }

    function getCommand(Request $request)
    {
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        if (!$cmd) {
            return self::$default_cmd;
        }

        $cmd = str_replace(array('.' . $sep), "", $cmd);
        $filepath = "command{$sep}cmds{$sep}{$cmd}.php";
        $classname = "\\command\\{$cmd}";
        if (file_exists($filepath)) {
            @require_once($filepath);
            if (class_exists($classname)) {
                $cmd_class = new \ReflectionClass(($classname));
                if ($cmd_class->isSubclassOf(self::$base_cmd)) {
                    return $cmd_class->newInstance();
                } else {
                    $request->addFeedback("command {$cmd} is not a Command");
                }
            }
        }

        $request->addFeedback("command {$cmd} not found");
        return clone self::$default_cmd;
    }

}