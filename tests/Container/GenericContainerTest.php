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
        $container->register(C::class, static fn() => new C());

        $cObj = $container->get(C::class);

        self::assertInstanceOf(C::class, $cObj);
    }

    public function testAutowire(): void
    {
        $container = new GenericContainer();

        $aObject = $container->get(A::class);

        self::assertInstanceOf(A::class, $aObject);
        self::assertInstanceOf(B::class, $aObject->b);
        self::assertInstanceOf(C::class, $aObject->b->c);
    }

    public function testSingleton(): void
    {
        $container = new GenericContainer();

        $container->singleton(Singleton::class, static fn() => new Singleton());

        $singletonObject = $container->get(Singleton::class);
        self::assertInstanceOf(Singleton::class, $singletonObject);
        self::assertSame(1, $singletonObject::$count);

        $singletonObject = $container->get(Singleton::class);
        self::assertSame(1, $singletonObject::$count);
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

class Singleton
{
    public static int $count = 0;

    public function __construct()
    {
        ++self::$count;
    }
}