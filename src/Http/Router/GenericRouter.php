<?php

declare(strict_types=1);

namespace Samplest\Http\Router;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionException;
use Samplest\Container\Container;
use Samplest\Http\Request\Request;
use Samplest\Http\Response\Response;
use Samplest\Http\Router\Exception\HttpNotFoundException;

final readonly class GenericRouter implements Router
{
    public function __construct(
        private RouterConfig $routerConfig,
        private Container $container,
    ) {}

    /**
     * @throws ReflectionException|HttpNotFoundException
     */
    public function dispatch(Request $request): Response
    {
        foreach ($this->routerConfig->controllers as $controllerClass) {
            $reflectionClass = new ReflectionClass($controllerClass);

            foreach ($reflectionClass->getMethods() as $method) {
                $routeAttribute = $method->getAttributes(Route::class, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

                if ($routeAttribute === null) {
                    continue;
                }

                /** @var Route $route */
                $route = $routeAttribute->newInstance();

                if ($route->method !== $request->getMethod()) {
                    continue;
                }

                $controller = $this->container->get($controllerClass);
                $methodName = $method->getName();

                if ($route->uri === $request->getUri()) {
                    return $controller->$methodName();
                }

                $controllerMethodParams = $this->resolveParams($route->uri, $request->getUri());

                if ($controllerMethodParams === null) {
                    continue;
                }

                return $controller->$methodName(...$controllerMethodParams);
            }

        }

        throw new HttpNotFoundException('Controller not found');
    }

    private function resolveParams(string $routeUri, string $requestUri): ?array
    {
        $result = preg_match_all('/\{\w+}/', $routeUri, $tokens);
        if (!$result) {
            return null;
        }

        $tokens = $tokens[0];

        $regexPattern = sprintf(
            '/^%s$/',
            str_replace(
                ['/', ...$tokens],
                ['\\/', ...array_fill(0, count($tokens), '([\w\d\s]+)')],
                $routeUri,
            ),
        );

        $result = preg_match_all($regexPattern, $requestUri, $matches);

        if ($result === 0) {
            return null;
        }

        unset($matches[0]);

        $matches = array_values($matches);

        $valueMap = [];

        foreach ($matches as $index => $match) {
            $valueMap[trim($tokens[$index], '{}')] = $match[0];
        }

        return $valueMap;
    }
}