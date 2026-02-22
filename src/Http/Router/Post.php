<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

use Attribute;
use Samplest\Http\Request\Method;

#[Attribute]
final readonly class Post extends Route
{
    public function __construct(
        string $uri,
    ) {
        parent::__construct($uri, Method::POST);
    }
}
