<?php

namespace Jrs\Example;

/**
 * This class is only for tests. Used to resolve complex situations, where
 * you want to use interfaces rather than explicit classes in constructors
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
interface SimpleInterface
{
    public function foo(): string;
}
