<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $firstname = config('contoh.author.first');
        $lastname = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        self::assertEquals('Al', $firstname);
        self::assertEquals('Syam', $lastname);
        self::assertEquals('malsyam@gmail.com', $email);
        self::assertEquals('www.al.com', $web);
    }
}
