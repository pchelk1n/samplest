<?php

declare(strict_types=1);

namespace Samplest\Container;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionParameter;

final class GenericContainer implements Container
{
    /**
     * @var array<string, callable>
     */
    private array $definitions = [];

    /**
     * @var array<class-string, object>
     */
    private array $singletons = [];

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function singleton(string $className, callable $definition): self
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
     * @param class-string $className
     *
     * @throws ReflectionException
     */
    private function autowire(string $className): object
    {
        $reflectionClass = new ReflectionClass($className);
        $parameters = array_map(
            $this->getReflectionParameterType(...),
            $reflectionClass->getConstructor()?->getParameters() ?? [],
        );

        return new $className(...$parameters);
    }

    private function getReflectionParameterType(ReflectionParameter $parameter): object
    {
        /** @var ReflectionNamedType|null $parameterType */
        $parameterType = $parameter->getType();

        if ($parameterType === null) {
            throw new InvalidArgumentException('Parameter type not found');
        }

        return $this->get($parameterType->getName());
    }
}
