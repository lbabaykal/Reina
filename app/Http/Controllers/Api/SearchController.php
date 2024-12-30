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
            'types' => TypesResource::collection((new Type)->cache()),
            'genres' => GenresResource::collection((new Genre)->cache()),
            'studios' => StudiosResource::collection((new Studio)->cache()),
            'countries' => CountriesResource::collection((new Country)->cache()),
            'sorting' => [
                ['id'=> 1, 'title' => 'По дате обновления', 'slug' => 'date_updated'],
                ['id'=> 2, 'title' => 'По рейтингу', 'slug' => 'rating'],
                ['id'=> 3, 'title' => 'По дате выхода ▲', 'slug' => 'premiere_asc'],
                ['id'=> 4, 'title' => 'По дате выхода ▼', 'slug' => 'premiere_desc'],
            ],
        ]);
    }
}
