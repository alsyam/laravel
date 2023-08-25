<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('Hello syam');

        $this->get('/hello-again')
            ->assertSeeText('Hello al');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('Hello alsyam');
    }
    public function testTemplate()
    {
        $this->view(' hello', ['name' => 'syam'])
            ->assertSeeText('Hello syam');

        $this->view('hello.world', ['name' => 'alsyam'])
            ->assertSeeText('Hello alsyam');
    }
}
