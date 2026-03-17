<?php

declare(strict_types=1);

namespace Tests\Unit\Services;

use App\DTOs\JokeData;
use App\Services\JokeService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class JokeServiceTest extends TestCase
{
    private JokeService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new JokeService();
    }

    public function test_it_fetches_and_transforms_jokes_into_a_collection_of_dtos(): void
    {
        $mockData = [
            ['type' => 'programming', 'setup' => 'Setup 1', 'punchline' => 'Punch 1', 'id' => 1],
            ['type' => 'programming', 'setup' => 'Setup 2', 'punchline' => 'Punch 2', 'id' => 2],
            ['type' => 'programming', 'setup' => 'Setup 3', 'punchline' => 'Punch 3', 'id' => 3],
            ['type' => 'programming', 'setup' => 'Setup 4', 'punchline' => 'Punch 4', 'id' => 4],
        ];

        Http::fake([
            'official-joke-api.appspot.com/*' => Http::response($mockData, 200),
        ]);

        $jokes = $this->service->getJokes(limit: 3);

        $this->assertCount(3, $jokes);
        $this->assertInstanceOf(JokeData::class, $jokes->first());
        $this->assertEquals('Setup 1', $jokes->first()->setup);
        $this->assertEquals(1, $jokes->first()->id);
    }

    public function test_it_returns_an_empty_collection_if_the_api_fails(): void
    {
        Http::fake([
            'official-joke-api.appspot.com/*' => Http::response([], 500),
        ]);

        $jokes = $this->service->getJokes(limit: 3);

        $this->assertCount(0, $jokes);
        $this->assertTrue($jokes->isEmpty());
    }
}
