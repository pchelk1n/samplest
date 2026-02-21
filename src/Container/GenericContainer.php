<?php

declare(strict_types=1);

namespace Samplest\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

final class GenericContainer implements Container
{
    private array $definitions = [];

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function get(string $className): object
    {
        $definition = $this->definitions[$className] ?? $this->autowire(...);

        return $definition($className);
    }

    /**
     * @throws ReflectionException
     */
    private function autowire(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);
        $parameters = array_map(
            fn (ReflectionParameter $parameter): object => $this->get($parameter->getType()?->getName()),
            $reflectionClass->getConstructor()?->getParameters() ?? [],
        );

        return new $className(...$parameters);
    }
}