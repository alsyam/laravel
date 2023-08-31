<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlGenerationTest extends TestCase
{
    public function testUrlCurrent()
    {
        $this->get('/url/current?name=Eko')
            ->assertSeeText("url/current?name=Eko");
    }
}
