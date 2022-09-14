<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UrlControllerTest extends TestCase
{
    private int $existingUrlId;

    public function setUp(): void
    {
        parent::setUp();

        $this->existingUrlId = DB::table('urls')->insertGetId([
            'name' => 'https://example.com',
            'created_at' => now()
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));

        $response->assertOk();
    }

    public function testShow(): void
    {
        $response = $this->get(route('urls.show', $this->existingUrlId));

        $response->assertOk();
    }

    public function testShowWithNoId(): void
    {
        $nonexistentId = '1000';

        $response = $this->get(route('urls.show', $nonexistentId));

        $response->assertNotFound();
    }

    public function testStore(): void
    {
        $newUrl = 'https://example2.com';
        $body = [
            'url' => [
                'name' => $newUrl
            ]
        ];

        $response = $this->post(route('urls.store'), $body);

        $response->assertRedirect();

        $this->assertDatabaseHas('urls', ['name' => $newUrl]);

        $response->assertSessionHasNoErrors();
    }

    public function testStoreWithFailUrl(): void
    {
        $failUrl = 'example';
        $body = [
            'url' => [
                'name' =>  $failUrl
            ]
        ];

        $response = $this->post(route('urls.store'), $body);

        $this->assertDatabaseMissing('urls', ['name' =>  $failUrl]);

        $response->assertSessionHasErrors(['url.name']);
    }

    public function testStoreWithExistingUrl(): void
    {
        $body = [
            'url' => [
                'name' => 'https://example.com'
            ]
        ];
        $response = $this->post(route('urls.store'), $body);

        $response->assertRedirect();

        $this->assertDatabaseCount('urls', 1);
    }
}
