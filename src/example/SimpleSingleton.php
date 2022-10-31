<?php

namespace Jrs\Example;

/**
 * This class is only for tests. Used to test Container's "singleton" and "get" methods
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class SimpleSingleton
{
    private static $instance;

    /**
     * Private to turn this a singleton. Only will be instantiate
     * using getInstance method.
     */
    private function __construct()
    {
    }

    /**
     * Use this method to create or get the singleton of this class.
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new SimpleSingleton();
        }
        return self::$instance;
    }
}
