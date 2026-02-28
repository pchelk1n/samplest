<?php

declare(strict_types=1);

namespace Samplest\Http\Response;

interface Response
{
    public Status $status {
        get;
    }

    public string $body {
        get;
    }
}
