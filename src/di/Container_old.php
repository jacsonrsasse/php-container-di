<?php

namespace Jrs\DI;

use Jrs\DI\Exception\ContainerException;
use Jrs\DI\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $entries = [];
    private array $forEntries = [];

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     * @return mixed Entry.
     */
    public function get(string $id, array $arguments = []): mixed
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry;
        }

        return $this->resolve($id, $arguments);
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
     * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
     *
     * @param string $id Identifier of the entry to look for.
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    private function resolve(string $id, array $arguments = []): mixed
    {
        $reflectionClass = new \ReflectionClass($id);
        if (! $reflectionClass->isInstantiable()) {
            throw new ContainerException("Class $id is not an instantiable class!");
        }

        $contructor = $reflectionClass->getConstructor();
        if (! $contructor || $contructor->getNumberOfParameters() == 0) {
            return $reflectionClass->newInstance();
        }

        $parameters = $contructor->getParameters();
        $dependencies = array_map(function (\ReflectionParameter $parameter) use ($id, $arguments) {

            if (! $parameter->hasType()) {
                throw new ContainerException(
                    "Impossible to instanciate the class '$id' because one of its parameters is not typed, and any
                    'resolver' has informaded."
                );
            }

            $name = $parameter->getName();
            $type = $parameter->getType();

            // @todo Implementar a lógica para o ReflectionUnionType
            if ($type instanceof \ReflectionUnionType) {
                throw new ContainerException(
                    "Failed to resolve class '$id', because of the parameter '$name'
                     is an union type, and this version does not support union types yet!"
                );
            }

            if ($type instanceof \ReflectionNamedType && $type->isBuiltin()) {
                throw new ContainerException(
                    "Failed to resolve class '$id', because of the parameter '$name' is a built - in type!"
                );
            }

            if (key_exists($type->getName(), $arguments)) {
                $classToResolve = $this->getClassToResolve($id, $type->getName(), $arguments);
                $argsToResolve  = $this->getArgumentsToResolve($type->getName(), $arguments);
                return $this->get($classToResolve, $argsToResolve);
            }

            return $this->get($type->getName());
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }

    private function getClassToResolve(string $masterClass, string $needToResolve, array $arguments): string
    {
        if (! isset($arguments[$needToResolve])) {
            throw new NotFoundException(
                "Not found the arguments to resolve '$needToResolve' argument of '$masterClass'"
            );
        }

        $argumentsToResolve = $arguments[$needToResolve];

        if (
            ! is_array($argumentsToResolve) ||
            ! isset($argumentsToResolve['class']) ||
            $argumentsToResolve['class'] === ''
        ) {
            throw new NotFoundException(
                "The arguments passed to resolve '$masterClass' must be an array with a 'class'
                key to resolve '$needToResolve' parameter!"
            );
        }

        return $argumentsToResolve['class'];
    }

    private function getArgumentsToResolve(string $needToResolve, array $arguments): array
    {
        $argumentsToResolve = $arguments[$needToResolve];
        return isset($argumentsToResolve['arguments']) ? $argumentsToResolve['arguments'] : [];
    }
}
