<?php

namespace Tests\Feature;

use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText("OK")
            ->assertSessionHas("userId", "alsyam")
            ->assertSessionHas("isMember", true);
    }

    public function testGetSession()
    {
        $this->withSession([
            'userId' => 'alsyam',
            'isMember' => 'true',
        ])->get('/session/get')
            ->assertSeeText('User Id : alsyam, Is Member : true');
    }
    public function testGetSessionFailed()
    {
        $this->get('/session/get')
            ->assertSeeText('User Id : guest, Is Member : false');
    }
}
