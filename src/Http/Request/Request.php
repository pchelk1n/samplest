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

    public array $body {
        get;
    }
}
