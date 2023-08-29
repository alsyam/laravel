<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testCreateCoookie()
    {
        $this->get('/cookie/set')
            ->assertSeeText('Hello Cookie')
            ->assertCookie('User-Id', 'al')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCoookie()
    {
        $this->withCookie("User-Id", 'al')
            ->withCookie("Is-Member", 'true')
            ->get('/cookie/get')
            ->assertJson([
                'userId' => 'al',
                'isMember' => 'true'
            ]);
    }
}
