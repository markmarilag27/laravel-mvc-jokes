<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Jokes;

use App\Http\Controllers\Controller;
use App\Services\JokeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetJokeController extends Controller
{
    public function __construct(
        private readonly JokeService $jokeService
    ) {}

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        /** @var int $limit */
        $limit = (int) $request->input('limit', 3);

        $resource = $this->jokeService->getJokes(limit: $limit);

        return response()->json([
            'data' => $resource,
        ]);
    }
}
