<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Env;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnvironmentTest extends TestCase
{
    public function testGetEnv()
    {

        $youtube = env('YOUTUBE');

        self::assertEquals('Programmer Zaman Now', $youtube);
    }

    public function testDefaultTest()
    {
        $author = Env::get('AUTHOR', 'Eko');

        self::assertEquals('Eko', $author);
    }
}
