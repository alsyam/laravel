<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NewInputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('/input/hello?name=Alsyam')
            ->assertSeeText('Hello Alsyam');

        $this->post('/input/hello', [
            'name' => 'Alsyam'
        ])->assertSeeText('Hello Alsyam');
    }

    public function testNestedInput()
    {
        $this->post('/input/hello/first', [
            "name" => [
                "first" => "al",
                "last" => "syam"
            ]
        ])->assertSeeText('Hello al');
    }
}
