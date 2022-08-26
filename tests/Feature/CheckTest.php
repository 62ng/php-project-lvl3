<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCheck()
    {
        $urlName = 'http://test.ru';

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now()
        ]);

        Http::fake([
            $urlName => Http::response('ok', 200, [])
        ]);

        $response = $this->post(route('check_post', $id));

        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $id,
            'status_code' => 200
        ]);
    }
}
