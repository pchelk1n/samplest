<?php

declare(strict_types=1);

namespace Test\Http\Router;

use Samplest\Http\Request\GenericRequest;
use Samplest\Http\Request\Method;
use Samplest\Http\Response\Status;
use Samplest\Http\Router\Router;
use Test\SDK\SamplestTestCase;

final class GenericRouterSamplestTest extends SamplestTestCase
{
    public function testGetRoute(): void
    {
        $router = $this->container->get(Router::class);

        $response = $router->dispatch(new GenericRequest(
            method: Method::GET,
            uri: '/home',
        ));

        $this->assertSame(Status::HTTP_200, $response->getStatus());
        self::assertSame('test', $response->getBody());
    }

    public function testGetRouteWithVariables(): void
    {
        $router = $this->container->get(Router::class);

        $response = $router->dispatch(new GenericRequest(
            method: Method::GET,
            uri: '/show/dima',
        ));

        $this->assertSame(Status::HTTP_200, $response->getStatus());
        self::assertSame('dima', $response->getBody());
    }
}
