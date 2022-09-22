<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UrlCheckControllerTest extends TestCase
{
    private int $urlId;
    private string $urlName;

    public function setUp(): void
    {
        parent::setUp();

        $this->urlName = 'https://example.com';

        $this->urlId = DB::table('urls')->insertGetId([
            'name' => $this->urlName,
            'created_at' => now()
        ]);
    }

    public function testStore()
    {
        $fakeHtmlFilePath = __DIR__ . '/../fixtures/fake_page.html';
        $fakePageHtml = file_get_contents($fakeHtmlFilePath);

        if (!$fakePageHtml) {
            throw new \Exception("Non-existing  {$fakeHtmlFilePath}");
        }

        Http::fake([
            $this->urlName => Http::response($fakePageHtml, 200, [])
        ]);

        $response = $this->post(route('urls.checks.store', $this->urlId));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('url_checks', [
            'url_id' => $this->urlId,
            'status_code' => 200,
            'h1' => 'H1',
            'title' => 'Title',
            'description' => 'Description',
        ]);
    }
}
