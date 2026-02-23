<?php

declare(strict_types=1);

namespace App\Controller;

use Samplest\Http\Response\GenericResponse;
use Samplest\Http\Response\Response;
use Samplest\Http\Response\Status;
use Samplest\Http\Router\Get;

final readonly class HomeController
{

    #[Get(uri: '/home')]
    public function index(): Response
    {
        return new GenericResponse(Status::HTTP_200, 'test');
    }

    #[Get(uri: '/show/{name}')]
    public function show(string $name): Response
    {
        return new GenericResponse(Status::HTTP_200, $name);
    }
}