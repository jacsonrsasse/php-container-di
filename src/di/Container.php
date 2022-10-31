<?php

namespace Jrs\DI;

use Jrs\DI\Exception\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface
{
    public function get(string $id)
    {
        return $this->resolveClass($id);
    }

    public function has(string $id): bool
    {
        return true;
    }

    private function resolveClass(string $id): mixed
    {
        $reflection = new ReflectionClass($id);
        $constructor = $reflection->getConstructor();

        if ($constructor->isPrivate()) {
            throw new ContainerException(
                "Trying to instantiate a class with a private construtor. You must use the 'singleton' method!"
            );
        }

        if ($constructor->getNumberOfParameters() === 0) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();

        $dependencies = array_map(function (\ReflectionParameter $parameter) {

            $type = $parameter->getType();

            if ($type->isBuiltin()) {
            }
        }, $parameters);
    }
}
