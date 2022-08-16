<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function testFormPage(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testForm(): void
    {
        $body = [
            'url' => [
                'name' => '2'
            ]
        ];

        $response = $this->post('/', $body);

        $response->assertRedirect();
    }
}
