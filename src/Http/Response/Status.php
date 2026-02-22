<?php

declare(strict_types=1);

namespace Samplest\Http\Response;

enum Status: string
{
    case HTTP_200 = '200';
    case HTTP_404 = '404';
}
