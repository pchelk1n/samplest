<?php

declare(strict_types=1);

namespace Samplest\Http\Request;

interface Request
{
    public function getMethod(): Method;

    public function getUri(): string;

    public function getBody(): array;
}