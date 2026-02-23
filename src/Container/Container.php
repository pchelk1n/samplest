<?php

declare(strict_types=1);

namespace Samplest\Container;

interface Container
{
    public function register(string $className, callable $definition): self;

    public function singleton(string $className, callable $definition): self;

    /**
     * @template T of object
     * @param class-string<T> $className
     * @return T
     */
    public function get(string $className): object;
}
