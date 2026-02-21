<?php

declare(strict_types=1);

namespace Container;

use Samplest\Container\GenericContainer;
use PHPUnit\Framework\TestCase;

final class GenericContainerTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new GenericContainer();
        $container->register(A::class, fn() => new A());

        $a = $container->get(A::class);

        self::assertInstanceOf(A::class, $a);
    }
}

class A
{

}