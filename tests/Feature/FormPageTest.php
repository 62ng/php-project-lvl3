<?php

namespace Tests\Feature;

use Tests\TestCase;

class FormPageTest extends TestCase
{
    public function testFormPage(): void
    {
        $response = $this->get(route('form'));

        $response->assertOk();
    }
}
