<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceContainerTest extends TestCase
{
    public function testCreateDependency()
    {
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertEquals("Foo", $foo1->foo());
        self::assertEquals("Foo", $foo2->foo());
        self::assertNotSame($foo1, $foo2);
    }

    public function testBind()
    {
        $this->app->bind(Person::class, function ($app) {
            return new Person("Al", "Syam");
        });

        $person1 = $this->app->make(Person::class); //closure() // new Person("Al", "Syam")
        $person2 = $this->app->make(Person::class);  //closure() // new Person("Al", "Syam")

        self::assertEquals('Al', $person1->firstName);
        self::assertEquals('Al', $person2->firstName);
        self::assertNotSame($person1, $person2);
    }


    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person("Al", "Syam");
        });

        $person1 = $this->app->make(Person::class); // new Person("Al", "Syam") if not exits
        $person2 = $this->app->make(Person::class);  //return existing

        self::assertEquals('Al', $person1->firstName);
        self::assertEquals('Al', $person2->firstName);
        self::assertSame($person1, $person2);
    }


    public function testInstance()

    {
        $person = new Person('Al', 'Syam');
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class); // person
        $person2 = $this->app->make(Person::class);  // person
        $person3 = $this->app->make(Person::class);  // person
        $person4 = $this->app->make(Person::class);  // person

        self::assertEquals('Al', $person1->firstName);
        self::assertEquals('Al', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app) {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });


        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);
        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Al', $helloService->hello('Al'));
    }
}
