<?php

namespace Tests\Unit;

use Jrs\DI\Container;
use PHPUnit\Framework\TestCase;

/**
 * Container's Tests
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class ContainerTest extends TestCase
{
    private $container;

    protected function setUp(): void
    {
        $this->container = new Container();
    }

    protected function tearDown(): void
    {
        unset($this->container);
    }
}
