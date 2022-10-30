<?php

namespace Jrs\Example;

/**
 * This class is only for tests. It is using an interface in constructor, and the
 * Container class must be able to solve this situation.
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class ComplexConstructorUsingInterfaces
{
    public function __construct(private SimpleInterface $class)
    {
    }

    public function print(): string
    {
        return $this->class->foo();
    }
}
