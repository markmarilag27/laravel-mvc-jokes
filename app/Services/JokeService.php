<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\JokeData;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class JokeService
{
    private string $endpoint = 'https://official-joke-api.appspot.com/jokes/programming/ten';

    /**
     * @return Collection<int, JokeData>
     */
    public function getJokes(int $limit = 3): Collection
    {
        $response = Http::get(
            url: $this->endpoint
        );

        if ($response->failed()) {
            return collect();
        }

        /** @var array<int, array<string, mixed>> $data */
        $data = $response->json();

        return collect($data)
            ->take($limit)
            ->map(fn (array $item): JokeData => JokeData::fromArray($item));
    }
}
