<?php

namespace Jrs\Example;

/**
 * This class is only for tests. It is used as dependency in SimpleConstructor class
 *
 * @see SimpleConstructor
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class SimpleInjectedClass
{
    public function foo(): string
    {
        return 'foo';
    }
}
