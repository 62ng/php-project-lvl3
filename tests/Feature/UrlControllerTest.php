<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testUrlsPage(): void
    {
        $response = $this->get(route('urls.index'));

        $response->assertStatus(200);
    }

    public function testUrlPage(): void
    {
        $id = DB::table('urls')->insertGetId([
            'name' => 'http://example.com'
        ]);

        $response = $this->get(route('urls.show', $id));

        $response->assertStatus(200);
    }

    public function testUrlPage404(): void
    {
        $id = '1000';

        $response = $this->get(route('urls.show', $id));

        $response->assertStatus(404);
    }

    public function testCreateUrlPage(): void
    {
        $response = $this->get(route('form'));

        $response->assertStatus(200);
    }

    public function testCreateUrl(): void
    {
        $body = [
            'url' => [
                'name' => 'https://example.com'
            ]
        ];

        $response = $this->post(route('urls.store'), $body);

        $response->assertRedirect();

        $this->assertDatabaseHas('urls', ['name' => 'https://example.com']);
    }

    public function testCreateBrakedUrl(): void
    {
        $url = 'blabla';
        $body = [
            'url' => [
                'name' =>  $url
            ]
        ];

        $this->post(route('urls.store'), $body);

        $this->assertDatabaseMissing('urls', ['name' =>  $url]);
    }
}
