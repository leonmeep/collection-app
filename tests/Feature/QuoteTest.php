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

    public function test_get_single_quote()
    {
        Quote::factory()->create();

        $response = $this->getJson('/api/quotes/1');

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json)
            {
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    ->has('data', function (AssertableJson $json)
                    {
                        $json->hasAll(['id', 'character', 'words', 'episode_name', 'episode_number', 'series_number'])
                            ->whereAllType([
                                'id' => 'integer',
                                'character' => 'string',
                                'words' => 'string',
                                'episode_name' => 'string',
                                'episode_number' => 'integer',
                                'series_number' => 'integer'
                            ]);

                    });


            });
    }






}
