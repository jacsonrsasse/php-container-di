<?php

namespace Jrs\Example;

class SimpleConstructorWithoutArguments implements PrintableInterface
{
    private string $foo;

    public function __construct()
    {
        $this->foo = 'foo';
    }

    public function print(): string
    {
        return $this->foo;
    }
}
