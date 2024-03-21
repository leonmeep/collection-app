<?php

namespace Tests\Feature;

use App\Models\Quote;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class QuoteTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_all_quotes(): void
    {
        Quote::factory()->count(3)->create();

        $response = $this->getJson('/api/quotes');

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->has('data', 3, function (AssertableJson $json)
                    {
                        $json->hasAll(['id', 'character', 'words'])
                        ->whereAllType([
                            'id' => 'integer',
                            'character' => 'string',
                            'words' => 'string'
                        ]);

                    });
            });
    }
}
