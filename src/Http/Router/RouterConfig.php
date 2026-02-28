<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

final readonly class RouterConfig
{
    /**
     * @param list<class-string> $controllers
     */
    public function __construct(
        public array $controllers = [],
    ) {}
}
