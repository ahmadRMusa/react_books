<?php

/**
 * Created by PhpStorm.
 * User: jielou
 * Date: 7/25/16
 * Time: 9:37 PM
 */

/**
 *
 * A general-purpose implementation that includes the optional functionality of
 * allowing multiple base directories for a single namespace prefix.
 *
 * In short, with a namespace mapper, we can find all the classes under the mapper directory.
 *
 * Given a foo-bar package of classes in the file system at the following
 * paths ...
 *
 *     /path/to/packages/foo-bar/
 *         src/
 *             Baz.php             # Foo\Bar\Baz
 *             Qux/
 *                 Quux.php        # Foo\Bar\Qux\Quux
 *         tests/
 *             BazTest.php         # Foo\Bar\BazTest
 *             Qux/
 *                 QuuxTest.php    # Foo\Bar\Qux\QuuxTest
 *
 * ... add the path to the class files for the \Foo\Bar\ namespace prefix
 * as follows:
 *
 *      <?php
 *      // instantiate the loader
 *      $loader = new \Example\Psr4AutoloaderClass;
 *
 *      // register the autoloader
 *      $loader->register();
 *
 *      // register the base directories for the namespace prefix
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/src');
 *      $loader->addNamespace('Foo\Bar', '/path/to/packages/foo-bar/tests');
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\Quux class from /path/to/packages/foo-bar/src/Qux/Quux.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\Quux;
 *
 * The following line would cause the autoloader to attempt to load the
 * \Foo\Bar\Qux\QuuxTest class from /path/to/packages/foo-bar/tests/Qux/QuuxTest.php:
 *
 *      <?php
 *      new \Foo\Bar\Qux\QuuxTest;
 */
class NamespaceRegistry
{

    /**
     * An associative array where the key is a namespace prefix and the value
     * is an array of base directories for classes in that namespace.
     *
     * @var array
     */
    protected $prefixes = array();

    private $project_dir;

    private static $instance = null;

    /**
     * @param null $project_dir
     * @return NamespaceRegistry|null
     *
     * TODO: We should avoid parameters here
     */
    public static function getInstance($project_dir = null)
    {
        if (is_null(self::$instance)) {
            self::$instance = new self($project_dir);
        }

        return self::$instance;
    }

    private function __construct($project_dir = null)
    {
        // normalize project dir
        $this->project_dir = '/' . trim($project_dir, '/') . '/';
    }

    /**
     * Register loader with SPL autoloader stack.
     *
     * @return void
     */
    public function register()
    {
        // http://php.net/manual/en/language.types.callable.php
        spl_autoload_register(array($this, 'loadClass'));
    }

    /**
     * Adds a base directory for a namespace prefix.
     *
     * @param string $prefix The namespace prefix.
     * @param string $base_dir A base directory for class files in the
     * namespace.
     * @param bool $prepend If true, prepend the base directory to the stack
     * instead of appending it; this causes it to be searched first rather
     * than last.
     * @return void
     */
    public function addNamespace($prefix, $base_dir, $prepend = false)
    {
        // normalize namespace prefix
        $prefix = trim($prefix, '\\') . '\\';

        // normalize the base directory with a trailing separator
        $base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

        // initialize the namespace prefix array
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }

        // retain the base directory for the namespace prefix
        if ($prepend) {
            // Prepend one or more elements to the beginning of an array
            array_unshift($this->prefixes[$prefix], $base_dir);
        } else {
            array_push($this->prefixes[$prefix], $base_dir);
        }
    }

    public function loadClass($namespace_class)
    {
        // the current namespace prefix. We should get one here if the class has a namespace.
        $namespace = $namespace_class;

        // a global namespace
        if (!strrpos($namespace, '\\')) {
            $mapped_file = $this->loadMappedFile("\\", $namespace);
            if ($mapped_file) {
                return $mapped_file;
            }
        }

        // work backwards through the namespace names of the fully-qualified class name to find a mapped file name
        while (false !== $pos = strrpos($namespace, '\\')) {

            // retain the trailing namespace separator in the prefix
            $namespace = substr($namespace_class, 0, $pos + 1);

            // the rest is the relative class name
            $relative_class = substr($namespace_class, $pos + 1);

            // try to load a mapped file for the prefix and relative class
            $mapped_file = $this->loadMappedFile($namespace, $relative_class);
            if ($mapped_file) {
                return $mapped_file;
            }

            // remove the trailing namespace separator for the next iteration of strrpos()
            $namespace = rtrim($namespace, '\\');
        }

        // never found a mapped file
        return false;

    }

    /**
     * Load the mapped file for a namespace prefix and relative class.
     *
     * @param string $prefix The namespace prefix.
     * @param string $classname The relative class name.
     * @return mixed Boolean false if no mapped file can be loaded, or the
     * name of the mapped file that was loaded.
     */
    protected function loadMappedFile($prefix, $classname)
    {
        // are there any base directories for this namespace prefix?
        if (isset($this->prefixes[$prefix]) === false) {
            return false;
        }

        // look through base directories for this namespace prefix
        foreach ($this->prefixes[$prefix] as $base_dir) {

            // replace namespace separators with directory separators in the class name, append with .php
            $file = $this->project_dir . $base_dir . str_replace('\\', '/', $classname) . '.php';

            // if the mapped file exists, require it
            if ($this->requireFile($file)) {
                return $file;
            }
        }

        return false;

    }

    private function requireFile($file)
    {
        if (file_exists($file)) {
            require_once $file;
            return true;
        }

        return false;
    }

}