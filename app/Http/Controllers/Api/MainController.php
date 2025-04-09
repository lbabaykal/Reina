<?php

namespace App\Http\Controllers\Api;

use App\Actions\MainAnimesAction;
use App\Actions\MainDoramasAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\MainResource;
use Illuminate\Http\JsonResponse;

class MainController extends Controller
{
    public function __invoke(MainAnimesAction $mainAnimesAction, MainDoramasAction $mainDoramasAction): JsonResponse
    {
        $animes = $mainAnimesAction->execute();
        $doramas = $mainDoramasAction->execute();

        return response()->json([
            'animes' => MainResource::collection($animes),
            'doramas' => MainResource::collection($doramas),
        ]);
    }
}
