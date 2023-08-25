<?php

namespace Tests\Feature;

// use GuzzleHttp\Psr7\Request;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Alsyam')
            ->assertSeeText('Hello Alsyam');

        $this->post('/input/hello', [
            'name' => 'Alsyam'
        ])->assertSeeText('Hello Alsyam');
    }

    public function testInputNested()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "al",
                "last" => "syam"
            ]
        ])->assertSeeText('Hello al');
    }
    public function testInputAll()
    {
        $this->post('/input/hello/input', [
            "name" => [
                "first" => "al",
                "last" => "syam"
            ]
        ])->assertSeeText('name')->assertSeeText('first')->assertSeeText('last')->assertSeeText('al')->assertSeeText('syam');
    }

    public function testInputArray()
    {
        $this->post('/input/hello/array', [
            "products" => [
                [
                    "name" => "Apple",
                    "price" => "10000000"
                ],                [
                    "name" => "Lenovo",
                    "price" => "10000000"
                ],                [
                    "name" => "Asus",
                    "price" => "10000000"
                ]
            ]
        ])->assertSeeText('Apple')->assertSeeText('Lenovo')->assertSeeText('Asus');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'al',
            'married' => 'true',
            'birth_date' => '2000-10-10'
        ])->assertSeeText('al')->assertSeeText('true')->assertSeeText('2000-10-10');
    }

    public function testFilterOnly()
    {
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "Muhammad",
                "middle" => "Al",
                "last" => "Syam"
            ]
        ])->assertSeeText("Muhammad")->assertSeeText("Syam")->assertDontSeeText("Al");
    }
    public function testFilterExcept()
    {
        $this->post('/input/filter/except', [

            "username" => "Muhammad",
            "admin" => "true",
            "password" => "rahasia"

        ])->assertSeeText("Muhammad")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }

    public function testFilterMerge()
    {
        $this->post('/input/filter/merge', [
            "username" => "Muhammad",
            "admin" => "true",
            "password" => "rahasia"
        ])->assertSeeText("Muhammad")->assertSeeText("rahasia")->assertSeeText("admin")->assertSeeText("false");
    }
}
