<?php

namespace Tests\Feature;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Laracasts\Flash\Message;
use Tests\TestCase;

class CheckTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCheck()
    {
        $urlName = 'http://example.com';

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now()
        ]);

        Http::fake([
            $urlName => Http::response('
                <html><head>
                <meta name="description" content="Description"></head>
                <title>Title</title>
                <h1>H1</h1></html>', 200, [])
        ]);

        $response = $this->post(route('check_post', $id));

        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $id,
            'status_code' => 200,
            'h1' => 'H1',
            'title' => 'Title',
            'description' => 'Description',
        ]);
    }

    public function testCreateCheckException()
    {
        $urlName = 'example';

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now()
        ]);

        $response = $this->post(route('check_post', $id));

        $response->assertRedirect();
    }
}
