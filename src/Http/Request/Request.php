<?php

declare(strict_types=1);

namespace Samplest\Http\Request;

interface Request
{
    public Method $method {
        get;
    }

    public string $uri {
        get;
    }

    /**
     * @var array<string, string> $body
     */
    public array $body {
        get;
    }
}
