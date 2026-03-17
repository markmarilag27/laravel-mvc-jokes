<?php

declare(strict_types=1);

namespace Tests\Unit\Controllers\Api\Jokes;

use App\DTOs\JokeData;
use App\Http\Controllers\Api\Jokes\GetJokeController;
use App\Services\JokeService;
use Mockery\MockInterface;
use Tests\TestCase;

class GetJokeControllerTest extends TestCase
{
    private string $endpoint;

    private int $limit = 3;

    protected function setUp(): void
    {
        parent::setUp();

        $this->endpoint = action(GetJokeController::class);
    }

    public function test_it_returns_jokes_with_default_limit(): void
    {
        $this->mock(JokeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJokes')
                ->once()
                ->with($this->limit)
                ->andReturn(collect([
                    new JokeData(1, 'programming', 'Setup 1', 'Punch 1'),
                    new JokeData(2, 'programming', 'Setup 2', 'Punch 2'),
                    new JokeData(3, 'programming', 'Setup 3', 'Punch 3'),
                ]));
        });

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200)
            ->assertJsonCount($this->limit, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'setup', 'punchline', 'type'],
                ],
            ]);
    }

    public function test_it_handles_custom_limit_parameter(): void
    {
        $customLimit = 5;

        $this->mock(JokeService::class, function (MockInterface $mock) use ($customLimit) {
            $mock->shouldReceive('getJokes')
                ->once()
                ->with($customLimit)
                ->andReturn(collect()->pad($customLimit, new JokeData(1, 'type', 's', 'p')));
        });

        $response = $this->getJson($this->endpoint."?limit={$customLimit}");

        $response->assertStatus(200)
            ->assertJsonCount($customLimit, 'data');
    }

    public function test_it_returns_empty_data_envelope_when_no_jokes_exist(): void
    {
        $this->mock(JokeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJokes')
                ->once()
                ->andReturn(collect());
        });

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200)
            ->assertExactJson(['data' => []]);
    }

    public function test_it_casts_string_limit_to_integer(): void
    {
        $this->mock(JokeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJokes')
                ->once()
                ->with(5)
                ->andReturn(collect());
        });

        $this->getJson($this->endpoint.'?limit=5');
    }

    public function test_it_handles_invalid_string_limit_as_zero(): void
    {
        $this->mock(JokeService::class, function (MockInterface $mock) {
            $mock->shouldReceive('getJokes')
                ->once()
                ->with(0)
                ->andReturn(collect());
        });

        $this->getJson($this->endpoint.'?limit=invalid-string');
    }
}
