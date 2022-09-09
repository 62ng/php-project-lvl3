<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UrlControllerTest extends TestCase
{
    public function testIndex(): void
    {
        $response = $this->get(route('urls.index'));

        $response->assertOk();
    }

    public function testShow(): void
    {
        $id = DB::table('urls')->insertGetId([
            'name' => 'http://example.com'
        ]);

        $response = $this->get(route('urls.show', $id));

        $response->assertOk();
    }

    public function testShowWithNoId(): void
    {
        $id = '1000';

        $response = $this->get(route('urls.show', $id));

        $response->assertNotFound();
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

        $response->assertSessionHasNoErrors();
    }

    public function testStoreWithFailUrl(): void
    {
        $url = 'blabla';
        $body = [
            'url' => [
                'name' =>  $url
            ]
        ];

        $response = $this->post(route('urls.store'), $body);

        $this->assertDatabaseMissing('urls', ['name' =>  $url]);

        $response->assertSessionHasErrors(['url.name']);
    }

    public function testStoreWithExistingUrl(): void
    {
        $body = [
            'url' => [
                'name' => 'https://example.com'
            ]
        ];

        $this->post(route('urls.store'), $body);

        $response = $this->post(route('urls.store'), $body);

        $response->assertRedirect();

        $this->assertDatabaseCount('urls', 1);
    }
}
