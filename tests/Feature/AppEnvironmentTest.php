<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppEnvironmentTest extends TestCase
{
    public function testAppEnv()
    {
        var_dump(App::environment());
    }
}
