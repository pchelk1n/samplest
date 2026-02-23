<?php

declare(strict_types=1);

namespace Test\SDK;

use App\Controller\HomeController;
use PHPUnit\Framework\TestCase;
use Samplest\Container\Container;
use Samplest\Container\GenericContainer;
use Samplest\Http\Router\GenericRouter;
use Samplest\Http\Router\Router;
use Samplest\Http\Router\RouterConfig;

class SamplestTestCase extends TestCase
{
    protected Container $container;

    public function setUp(): void
    {
        $this->container = new GenericContainer();

        $this->container->singleton(Container::class, fn() => $this->container);

        $this->container->singleton(
            className: Router::class,
            definition: static fn(Container $container): Router => $container->get(GenericRouter::class)
        );

        $this->container->singleton(
            className: RouterConfig::class,
            definition: static fn(): RouterConfig => new RouterConfig(
                controllers: [
                    HomeController::class,
                ],
            ),
        );
    }
}
