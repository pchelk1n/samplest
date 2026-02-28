<?php

declare(strict_types=1);

namespace Samplest\Http\Response;

final readonly class GenericResponse implements Response
{
    public function __construct(
        public Status $status,
        public string $body,
    ) {}
}
