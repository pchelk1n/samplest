<?php

declare(strict_types=1);

namespace Samplest\Http\Response;

final readonly class GenericResponse implements Response
{
    public function __construct(
        private Status $status,
        private string $body,
    ) {}

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getBody(): string
    {
        return $this->body;
    }
}
