<?php

namespace Tests\Unit;

use Jrs\DI\Container;
use Jrs\DI\Exception\ContainerException;
use Jrs\Example\SimpleConstructor;
use Jrs\Example\SimpleConstructorWithoutArguments;
use Jrs\Example\SimpleSingleton;
use PHPUnit\Framework\TestCase;

/**
 * Container's Tests
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class ContainerTest extends TestCase
{
    private $container;

    /**
     * Set up the test class
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->container = new Container();
    }

    /**
     * Called after execute a test and before destruct
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->container);
    }

    /**
     * Implements a simple test over "get", returning a class with a
     * simple dependency injection. If you see SimpleConstructor class
     * you will realize that it has a parameter of SimpleInjectedClass.
     * This Container must be able to resolve this problema using
     * "autowiring".
     *
     * @covers Container::get
     *
     * @return void
     */
    public function testSimpleGet(): void
    {
        $class = $this->container->get(SimpleConstructor::class);
        $this->assertInstanceOf(SimpleConstructor::class, $class);
    }

    /**
     * Implements a test over "get", trying to resolve a singleton
     * class. This test is expected to crash.
     *
     * @covers Container::get
     *
     * @return void
     */
    public function testGetClassWithPrivateConstruct(): void
    {
        try {
            $this->container->get(SimpleSingleton::class);
        } catch (ContainerException $containerException) {
            $this->assertEquals(
                "Trying to instantiate a class with a private construtor. You must use the 'singleton' method!",
                $containerException->getMessage()
            );
        }
    }

    /**
     * Implements a test over "get", getting a class who has
     * no arguments on its constructor.
     *
     * @covers Container::get
     *
     * @return void
     */
    public function testGetClassWithNoArgumentsInConstruct(): void
    {
        $class = $this->container->get(SimpleConstructorWithoutArguments::class);
        $this->assertEquals('foo', $class->print());
        $reflection = new \ReflectionClass($class);
        $this->assertEquals(0, $reflection->getConstructor()->getNumberOfParameters());
        unset($reflection);
    }
}
