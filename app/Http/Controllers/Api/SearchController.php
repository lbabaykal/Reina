<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountriesResource;
use App\Http\Resources\StudiosResource;
use App\Http\Resources\GenresResource;
use App\Http\Resources\TypesResource;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Studio;
use App\Models\Type;
use Illuminate\Http\JsonResponse;

class SearchController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'types' => TypesResource::collection(Type::all()),
            'genres' => GenresResource::collection(Genre::all()),
            'studios' => StudiosResource::collection(Studio::all()),
            'countries' => CountriesResource::collection(Country::all()),
        ]);
    }
}
