<?php

/**
 * Created by PhpStorm.
 * User: jlou
 * Date: 8/1/16
 * Time: 8:38 PM
 *
 * Do not use Registry Pattern
 * http://www.brandonsavage.net/the-registry-pattern-reexamined/
 *
 * Why use Registry Pattern
 * http://www.brandonsavage.net/use-registry-to-remember-objects-so-you-dont-have-to/
 *
 * Infer from JSP
 *
 * 1. page里的变量没法从index.jsp传递到test.jsp。只要页面跳转了，它们就不见了。
 *
 * 2. request里的变量可以跨越forward前后的两页。但是只要刷新页面，它们就重新计算了。
 *
 * 3. session和application里的变量一直在累加，开始还看不出区别，只要关闭浏览器，再次重启浏览器访问这页，session里的变量就重新计算了。
 *
 * 4. application里的变量一直在累加，除非你重启tomcat，否则它会一直变大。而作用域规定的是变量的有效期限。
 *
 *
 * 如果把变量放到pageContext里，就说明它的作用域是page，它的有效范围只在当前jsp页面里。从把变量放到pageContext开始，到jsp页面结束，你都可以使用这个变量。
 *
 * 如果把变量放到request里，就说明它的作用域是request，它的有效范围是当前请求周期。
 * 所谓请求周期，就是指从http请求发起，到服务器处理结束，返回响应的整个过程。在这个过程中可能使用forward的方式跳转了多个jsp页面，在这些页面里你都可以使用这个变量。
 *
 * 如果把变量放到session里，就说明它的作用域是session，它的有效范围是当前会话。所谓当前会话，就是指从用户打开浏览器开始，到用户关闭浏览器这中间的过程。这个过程可能包含多个请求响应。
 * 也就是说，只要用户不关浏览器，服务器就有办法知道这些请求是一个人发起的，整个过程被称为一个会话（session），而放到会话中的变量，就可以在当前会话的所有请求里使用。
 *
 * 如果把变量放到application里，就说明它的作用域是application，它的有效范围是整个应用。整个应用是指从应用启动，到应用结束。
 * 我们没有说“从服务器启动，到服务器关闭”，是因为一个服务器可能部署多个应用，当然你关闭了服务器，就会把上面所有的应用都关闭了。
 *
 * application作用域里的变量，它们的存活时间是最长的，如果不进行手工删除，它们就一直可以使用。
 *
 * 与上述三个不同的是，application里的变量可以被所有用户共用。如果用户甲的操作修改了application中的变量，用户乙访问时得到的是修改后的值。
 * 这在其他scope中都是不会发生的，page, request, session都是完全隔离的，无论如何修改都不会影响其他人的数据。
 *
 */
class DatabaseObj
{
    protected $_resource;

    protected $user = 'me';
    protected $pass = 'P@ssw0rd!';
    protected $db = 'mydb';

    public function __construct($user = null, $pass = null, $db = null)
    {
        // Connect to the database.
        $this->_resource = $returnedResource;
    }

    public function getData($string)
    {
        // Query the database
        return $resultResource;
    }

    public function clean($var)
    {
        // Do cleaning here.
        return $varClean;
    }
}

abstract class Registry
{

    protected static $_cache;

    public static function set($k, $v)
    {
        if (!is_object($v))
            throw new Exception('Object expected; ' . gettype($v) . ' given');

        if (!is_array(self::$_cache))
            self::$_cache = array();

        self::$_cache[$k] = $v;

        return $v;
    }

    public static function get($k)
    {
        if (isset(self::$_cache[$k]))
            return self::$_cache[$k];
        else
            throw new Exception("Object doesn't exist!");
    }
}

class Authenticate
{
    public function checkCredentials($user, $pass)
    {

        // it allows us to connect to more than one database server.
        // This is critical, especially for large applications
        // where your data may be assembled in a master-slave setup.
        $dbObj = Registry::get('mydb');

        $userClean = $dbObj->clean($user);
        $passClean = $dbObj->clean($pass);

        return $dbObj->getData('SELECT * FROM users WHERE user = "' . $userClean . '" AND pass = MD5("' . $passClean . '")');
    }
}

