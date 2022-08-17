<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function testUrlsPage(): void
    {
        $response = $this->get(route('urls'));

        $response->assertStatus(200);
    }

    public function testFormPage(): void
    {
        $response = $this->get(route('form'));

        $response->assertStatus(200);
    }

    public function testForm(): void
    {
        $body = [
            'url' => [
                'name' => '2'
            ]
        ];

        $response = $this->post(route('form_post'), $body);

        $response->assertRedirect();
    }
}
