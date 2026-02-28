<?php

declare(strict_types=1);

namespace Test\Container;

use PHPUnit\Framework\TestCase;
use Samplest\Container\GenericContainer;

final class GenericContainerTest extends TestCase
{
    public function testRegister(): void
    {
        $container = new GenericContainer();
        $container->register(C::class, static fn(): C => new C());

        $cObj = $container->get(C::class);

        $this->assertInstanceOf(C::class, $cObj);
    }

    public function testAutowire(): void
    {
        $container = new GenericContainer();

        $aObject = $container->get(A::class);

        $this->assertInstanceOf(A::class, $aObject);
        $this->assertInstanceOf(B::class, $aObject->b);
        $this->assertInstanceOf(C::class, $aObject->b->c);

        $cObject = $container->get(C::class);
        $this->assertInstanceOf(C::class, $cObject);
        $this->assertNotSame($cObject, $aObject->b->c);

        $aObject2 = $container->get(A::class);

        $this->assertNotSame($aObject, $aObject2);
    }

    public function testSingleton(): void
    {
        $container = new GenericContainer();

        $container->singleton(Singleton::class, static fn(): Singleton => new Singleton());

        $singletonObject = $container->get(Singleton::class);
        $this->assertInstanceOf(Singleton::class, $singletonObject);
        $this->assertSame(1, $singletonObject::$count);

        $sameSingletonObject = $container->get(Singleton::class);
        $this->assertSame(1, $sameSingletonObject::$count);

        $this->assertSame($singletonObject, $sameSingletonObject);
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

class C {}

class Singleton
{
    public static int $count = 0;

    public function __construct()
    {
        ++self::$count;
    }
}
