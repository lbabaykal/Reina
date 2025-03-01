<?php

namespace App\Services;

use App\Http\Requests\AdminPanel\AnimeUpdateRequest;
use App\Models\Anime;
use App\Services\Image\CoverService;
use App\Services\Image\PosterService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AnimeAdminServices
{
    public function store(Request $request): RedirectResponse
    {
        $anime = new Anime;

        $anime->poster = (new PosterService)->setStorage('s3_animes')->save();
        $anime->cover = (new CoverService)->setStorage('s3_animes')->save();

        $anime->slug = str()->slug($request->safe()->input('title_ru'));
        $anime->title_org = $request->safe()->input('title_org');
        $anime->title_ru = $request->safe()->input('title_ru');
        $anime->title_en = $request->safe()->input('title_en');

        $anime->type_id = $request->safe()->input('type');

        $anime->country_id = null;
        $countries = $request->safe()->input('countries') ?? null;

        $anime->genre_id = null;
        $genres = $request->safe()->input('genres') ?? null;

        $anime->studio_id = null;
        $studios = $request->safe()->input('studios') ?? null;

        $anime->age_rating = $request->safe()->input('age_rating');
        $anime->episodes_released = 0;
        $anime->episodes_total = $request->safe()->input('episodes_total');
        $anime->duration = $request->safe()->input('duration');
        $anime->release = $request->safe()->date('release');
        $anime->description = $request->safe()->input('description');
        $anime->status = $request->safe()->input('status');

        $anime->rating = 0;
        $anime->count_assessments = 0;

        $anime->is_comment = $request->safe()->boolean('is_comment');
        $anime->is_rating = $request->safe()->boolean('is_rating');

        try {
            DB::transaction(function () use ($anime, $countries, $genres, $studios) {
                $anime->save();

                $anime->countries()->attach($countries);
                $anime->genres()->attach($genres);
                $anime->studios()->attach($studios);
            });

            $anime->generateSlug();
            $anime->saveQuietly();

            return redirect()->route('admin.animes.index')->with('message', "Аниме {$anime->title_ru} добавлено.");
        } catch (\Exception $e) {

            if (! is_null($anime->poster)) {
                Storage::disk('s3_animes')->delete($anime->poster);
            }

            if (! is_null($anime->cover)) {
                Storage::disk('s3_animes')->delete($anime->cover);
            }

            return redirect()->back()->with('message', 'Ошибка выполнения транзакции.'.$e->getMessage());
        }
    }

    public function update(AnimeUpdateRequest $request, Model $anime): RedirectResponse
    {
        if (request()->has('poster')) {
            $anime->poster = (new PosterService)->setStorage('s3_animes')->save() ?? $anime->poster;
        }

        if (request()->has('cover')) {
            $anime->cover = (new CoverService)->setStorage('s3_animes')->save() ?? $anime->cover;
        }

        $anime->title_org = $request->safe()->input('title_org');
        $anime->title_ru = $request->safe()->input('title_ru');
        $anime->title_en = $request->safe()->input('title_en');

        $anime->type_id = $request->safe()->input('type');

        $anime->country_id = null;
        $countries = $request->safe()->input('countries') ?? null;

        $anime->genre_id = null;
        $genres = $request->safe()->input('genres') ?? null;

        $anime->studio_id = null;
        $studios = $request->safe()->input('studios') ?? null;

        $anime->age_rating = $request->safe()->input('age_rating');
        $anime->episodes_total = $request->safe()->input('episodes_total');
        $anime->duration = $request->safe()->input('duration');
        $anime->release = $request->safe()->input('release');
        $anime->description = $request->safe()->input('description');
        $anime->status = $request->safe()->input('status');

        $anime->rating = 0;
        $anime->count_assessments = 0;

        $anime->is_comment = $request->safe()->boolean('is_comment');
        $anime->is_rating = $request->safe()->boolean('is_rating');

        try {
            DB::transaction(function () use ($anime, $countries, $genres, $studios) {
                $anime->update();

                $anime->countries()->sync($countries);
                $anime->genres()->sync($genres);
                $anime->studios()->sync($studios);
            });

            return redirect()->route('admin.animes.index')->with('message', "Аниме {$anime->title_ru} обновлено.");
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Ошибка выполнения транзакции.'.$e);
        }
    }
}
