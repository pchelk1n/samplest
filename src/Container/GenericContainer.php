<?php

declare(strict_types=1);

namespace Samplest\Container;

use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

final class GenericContainer implements Container
{
    private array $definitions = [];

    private array $singletons = [];

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function singleton(string $className, callable $definition): Container
    {
        $this->definitions[$className] = function () use ($className, $definition): object {
            $instance = $definition($this);

            $this->singletons[$className] = $instance;

            return $instance;
        };

        return $this;
    }

    public function get(string $className): object
    {
        $singletonObject = $this->singletons[$className] ?? null;

        if ($singletonObject !== null) {
            return $singletonObject;
        }

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
            fn(ReflectionParameter $parameter): object => $this->get($parameter->getType()?->getName()),
            $reflectionClass->getConstructor()?->getParameters() ?? [],
        );

        return new $className(...$parameters);
    }
}
