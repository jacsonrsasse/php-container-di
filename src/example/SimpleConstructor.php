<?php

namespace Jrs\Example;

/**
 * This class is only for tests. It has a simple class injected as a dependency,
 * and the Container class must be able to resolve this situation, auto wiring
 * the SimpleInjectedClass and passing as parameter
 *
 * @author Jacson R. Sasse <jacsonrsasse@gmail.com>
 */
class SimpleConstructor implements PrintableInterface
{
    public function __construct(private SimpleInjectedClass $injectedClass)
    {
    }

    public function print(): string
    {
        return $this->injectedClass->foo();
    }
}
