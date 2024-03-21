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
                    ->has('data', 3, function (AssertableJson $json) {
                        $json->hasAll(['id', 'character', 'words'])
                            ->whereAllType([
                                'id' => 'integer',
                                'character' => 'string',
                                'words' => 'string',
                            ]);

                    });
            });
    }

    public function test_get_single_quote()
    {
        Quote::factory()->create();

        $response = $this->getJson('/api/quotes/1');

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message', 'data'])
                    ->whereType('message', 'string')
                    ->has('data', function (AssertableJson $json) {
                        $json->hasAll(['id', 'character', 'words', 'episode_name', 'episode_number', 'series_number'])
                            ->whereAllType([
                                'id' => 'integer',
                                'character' => 'string',
                                'words' => 'string',
                                'episode_name' => 'string',
                                'episode_number' => 'integer',
                                'series_number' => 'integer',
                            ]);

                    });

            });
    }

    public function test_updateQuote_invalidData(): void
    {
        Quote::factory()->create();
        $response = $this->putJson('/api/quotes/update/1', []);

        $response->assertInvalid(['character', 'words']);

    }

    public function test_updateQuote_success(): void
    {
        Quote::factory()->create();
        $response = $this->putJson('/api/quotes/update/1', [
            'character' => 'testing',
            'words' => 'also testing',
        ]);

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseHas('quotes', [
            'character' => 'testing',
            'words' => 'also testing',
        ]);
    }

    public function test_createQuote_invalidData(): void
    {
        Quote::factory()->create();
        $response = $this->postJson('/api/quotes/create', []);

        $response->assertInvalid(['character', 'words']);
    }

    public function test_createQuote_success(): void
    {
        Quote::factory()->create();
        $response = $this->postJson('/api/quotes/create', [
            'character' => 'testing',
            'words' => 'also testing',
        ]);

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])
                    ->whereType('message', 'string');
            });

        $this->assertDatabaseHas('quotes', [
            'character' => 'testing',
            'words' => 'also testing',
        ]);
    }

    public function test_deleteQuote_Success(): void
    {
        Quote::factory()->create();
        $response = $this->deleteJson('/api/quotes/delete/1');

        $response->assertStatus(201)
            ->assertJson(function (AssertableJson $json) {
                $json->hasAll(['message'])->whereType('message', 'string');
            });
        $this->assertDatabaseMissing('quotes', [
            'character' => 'testing',
            'words' => 'also testing',
        ]);
    }
}
