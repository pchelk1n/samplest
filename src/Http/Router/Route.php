<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

use Attribute;
use Samplest\Http\Request\Method;

#[Attribute]
readonly class Route
{
    public function __construct(
        public string $uri,
        public Method $method,
    ) {}
}
