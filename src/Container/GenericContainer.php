<?php

declare(strict_types=1);

namespace Samplest\Container;

final class GenericContainer implements Container
{
    private array $definitions = [];

    public function __construct(
        
    ) {}

    public function register(string $className, callable $definition): Container
    {
        $this->definitions[$className] = $definition;

        return $this;
    }

    public function get(string $className): object
    {
        $definition = $this->definitions[$className];

        return $definition();
    }
}