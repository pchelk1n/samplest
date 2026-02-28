<?php

declare(strict_types=1);

namespace Samplest\Http\Request;

final readonly class GenericRequest implements Request
{
    /**
     * @param non-empty-string $uri
     * @param array<string, string> $body
     */
    public function __construct(
        public Method $method,
        public string $uri,
        public array $body = [],
    ) {}
}
