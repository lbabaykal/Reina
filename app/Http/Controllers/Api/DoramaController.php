<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Filters\Fields\CountriesFilter;
use App\Http\Filters\Fields\GenresFilter;
use App\Http\Filters\Fields\SortingFilter;
use App\Http\Filters\Fields\StudiosFilter;
use App\Http\Filters\Fields\TitleFilter;
use App\Http\Filters\Fields\TypesFilter;
use App\Http\Filters\Fields\YearFromFilter;
use App\Http\Filters\Fields\YearToFilter;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\Doramas\DoramasIndexResource;
use App\Http\Resources\Doramas\DoramasShowResource;
use App\Http\Resources\Doramas\DoramasWatchResource;
use App\Http\Resources\Episodes\DoramaResource;
use App\Models\Dorama;
use App\Models\FolderDorama;
use App\Reina;
use App\Services\DoramasServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\View\View;

class DoramaController extends Controller
{
    public function index(SearchRequest $request)
    {
        $query = Dorama::query()->select(['id', 'slug', 'poster', 'title_ru', 'rating', 'episodes_released', 'episodes_total']);
        $doramas = Pipeline::send($query)
            ->through([
                TitleFilter::class,
                TypesFilter::class,
                GenresFilter::class,
                CountriesFilter::class,
                StudiosFilter::class,
                YearFromFilter::class,
                YearToFilter::class,
                SortingFilter::class,
            ])
            ->thenReturn();

        return DoramasIndexResource::collection($doramas->paginate(Reina::COUNT_ARTICLES_FULL, ['*'], 'page', request()->input('page', 1)));
    }

    public function show($slug, DoramasServices $doramasService): JsonResponse
    {
        $dorama = $doramasService->dataInCacheBySlug($slug);
        $ratingUser = $doramasService->ratingUserFor();
        $favoriteUser = $doramasService->favoriteUserFor();
        $foldersUser = $doramasService->foldersUserFor();
        $userFolderFavorite = $doramasService->userFolderFavorite();

        return response()->json([
            'dataDorama' => DoramasShowResource::make($dorama),
            'dataUserForDorama' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'id' => $userFolderFavorite->id,
                    'title' => $userFolderFavorite->title,
                ],
            ],
        ]);
    }

    public function watch($slug, DoramasServices $doramasService): JsonResponse
    {
        $dorama = $doramasService->dataInCacheBySlug($slug);
        $ratingUser = $doramasService->ratingUserFor();
        $favoriteUser = $doramasService->favoriteUserFor();
        $foldersUser = $doramasService->foldersUserFor();
        $userFolderFavorite = $doramasService->userFolderFavorite();

        $episodes = $dorama->doramaEpisodes()
            ->where('status', StatusEnum::PUBLISHED)
            ->orderBy('number')
            ->get();

        return response()->json([
            'dataDorama' => DoramasWatchResource::make($dorama),
            'dataUserForDorama' => [
                'rating' => $ratingUser,
                'favorite' => [
                    'id' => $userFolderFavorite->id,
                    'title' => $userFolderFavorite->title,
                ],
            ],
            'dataEpisodes' => DoramaResource::collection($episodes),
        ]);
    }

}
