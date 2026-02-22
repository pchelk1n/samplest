<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

use Samplest\Http\Request\Request;
use Samplest\Http\Response\Response;

interface Router
{
    public function dispatch(Request $request): Response;
}