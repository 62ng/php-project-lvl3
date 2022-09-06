<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));

        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $id = DB::table('urls')->insertGetId([
            'name' => 'http://example.com'
        ]);

        $response = $this->get(route('urls.show', $id));

        $response->assertStatus(200);
    }

    public function testShowWithNoId(): void
    {
        $id = '1000';

        $response = $this->get(route('urls.show', $id));

        $response->assertStatus(404);
    }

    public function testFormPage(): void
    {
        $response = $this->get(route('form'));

        $response->assertStatus(200);
    }

    public function testStore(): void
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

    public function testStoreWithFailUrl(): void
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
