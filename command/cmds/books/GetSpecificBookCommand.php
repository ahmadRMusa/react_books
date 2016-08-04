<?php
/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/3/16
 * Time: 11:59 PM
 */

namespace command;

use controller\Request;
use \business\BooksManager;

/**
 * Class GetSpecificBookCommand
 * @package command
 *
 * get a book via some condition
 *
 */
class GetSpecificBookCommand extends Command
{

    public function doExecute(Request $request)
    {
        $books_manager = new BooksManager();
        $res = $books_manager->getSpecificBook(array('author' => 'jie'));
        $request->addFeedback($res);
        return self::reformatStatus('CMD_OK');
    }

}