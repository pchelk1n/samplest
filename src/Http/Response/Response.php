<?php

declare(strict_types=1);

namespace Samplest\Http\Response;

interface Response
{
    public function getStatus(): Status;

    public function getBody(): string;
}
