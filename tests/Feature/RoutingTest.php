<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get("/al")
            ->assertStatus(200)
            ->assertSeeText("Hello Guys");
    }
    public function testRedirect()
    {
        $this->get("/youtube")
            ->assertRedirect('/al');
    }
    public function testFallback()
    {
        $this->get("/alss")
            ->assertSeeText('404 by al');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');


        $this->get('/products/1/items/XXX')
            ->assertSeeText('Product 1, Item XXX');
    }
    public function testRouteParameterRegex()
    {
        $this->get('/categories/100')
            ->assertSeeText('Category 100');

        $this->get('/categories/{al}')
            ->assertSeeText('404 by al');
    }

    public function testRouteParameterOptional()
    {
        $this->get('/users/als')
            ->assertSeeText('User als');


        $this->get('/users')
            ->assertSeeText('User 404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText('Conflict budi');

        $this->get('/conflict/al')
            ->assertSeeText('Conflict al syam');
    }

    public function testNamedRoute()
    {
        $this->get('product/12345')
            ->assertSeeText('Link http://localhost/products/12345');

        $this->get('/product-redirect/12345')
            ->assertRedirect('/products/12345');
    }
}
