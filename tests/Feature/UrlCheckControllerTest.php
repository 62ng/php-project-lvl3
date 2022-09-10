<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    public function testStore()
    {
        $urlName = 'http://example.com';

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now()
        ]);

//        $fakePageHtml = Storage::get(base_path() . '/tests/fixtures/fake_page.html');
        $fakePageHtml = file_get_contents(base_path() . '/tests/fixtures/fake_page.html');

        Http::fake([
            $urlName => Http::response($fakePageHtml, 200, [])
        ]);

        $response = $this->post(route('urls.checks.store', $id));

        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $id,
            'status_code' => 200,
            'h1' => 'H1',
            'title' => 'Title',
            'description' => 'Description',
        ]);
    }

    public function testStoreWithException()
    {
        $urlName = 'example';

        $id = DB::table('urls')->insertGetId([
            'name' => $urlName,
            'created_at' => now()
        ]);

        $response = $this->post(route('urls.checks.store', $id));

        $response->assertRedirect();
    }
}
