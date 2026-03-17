<?php

declare(strict_types=1);

namespace App\DTOs;

readonly class JokeData
{
    public function __construct(
        public int $id,
        public string $setup,
        public string $punchline,
        public string $type,
    ) {}

    /**
     * @param array{id: int, type: string, setup: string, punchline: string} $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            setup: $data['setup'],
            punchline: $data['punchline'],
            type: $data['type'],
        );
    }
}
