<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCheck()
    {
        $id = 9;
        $response = $this->post(route('check_post', $id));

        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', ['url_id' => $id]);
    }
}
