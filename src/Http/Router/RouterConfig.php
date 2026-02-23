<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

final readonly class RouterConfig
{
    public function __construct(
        public array $controllers = [],
    ) {}
}
