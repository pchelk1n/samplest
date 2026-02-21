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
        $container->register(C::class, fn() => new C());

        $obj = $container->get(C::class);

        self::assertInstanceOf(C::class, $obj);
    }

    public function testAutowire(): void
    {
        $container = new GenericContainer();

        $a = $container->get(A::class);

        self::assertInstanceOf(A::class, $a);
        self::assertInstanceOf(B::class, $a->b);
        self::assertInstanceOf(C::class, $a->b->c);
    }
}

class A
{
    public function __construct(
        public B $b,
    ) {}

}

class B
{
    public function __construct(
        public C $c,
    ) {}
}

class C
{
}