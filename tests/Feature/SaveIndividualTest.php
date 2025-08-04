<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaveIndividualTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_saves_an_individual_client()
    {
        $payload = [
            'client' => [
                'title' => 'Mr',
                'first_name' => 'John',
                'initial' => 'D',
                'last_name' => 'Doe',
            ],
        ];

        $response = $this->postJson('/api/save-individual', $payload);

        $response->assertStatus(201)
                 ->assertJson([
                     'data' => [
                        'title' => 'Mr',
                        'first_name' => 'John',
                        'initial' => 'D',
                        'last_name' => 'Doe',
                    ]
                 ]);

        $this->assertDatabaseHas('people', [
            'title' => 'Mr',
            'first_name' => 'John',
            'initial' => 'D',
            'last_name' => 'Doe',
        ]);
    }
}
