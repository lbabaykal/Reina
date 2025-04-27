<?php

namespace App\Services;

use App\Enums\S3Enum;
use App\Http\Requests\AdminPanel\DoramaUpdateRequest;
use App\Models\Dorama;
use App\Services\Image\CoverService;
use App\Services\Image\PosterService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DoramaAdminServices
{
    public function store(Request $request): RedirectResponse
    {
        $dorama = new Dorama;

        $dorama->poster = (new PosterService)->setStorage(S3Enum::DORAMAS->value)->save();
        $dorama->cover = (new CoverService)->setStorage(S3Enum::DORAMAS->value)->save();

        $dorama->slug = str()->slug($request->safe()->input('title_ru'));
        $dorama->title_org = $request->safe()->input('title_org');
        $dorama->title_ru = $request->safe()->input('title_ru');
        $dorama->title_en = $request->safe()->input('title_en');

        $dorama->type_id = $request->safe()->input('type');

        $dorama->country_id = null;
        $countries = $request->safe()->input('countries') ?? null;

        $dorama->genre_id = null;
        $genres = $request->safe()->input('genres') ?? null;

        $dorama->studio_id = null;
        $studios = $request->safe()->input('studios') ?? null;

        $dorama->age_rating = $request->safe()->input('age_rating');
        $dorama->episodes_released = 0;
        $dorama->episodes_total = $request->safe()->input('episodes_total');
        $dorama->duration = $request->safe()->input('duration');
        $dorama->release = $request->safe()->date('release');
        $dorama->description = $request->safe()->input('description');
        $dorama->status = $request->safe()->input('status');

        $dorama->rating = 0;
        $dorama->count_assessments = 0;

        $dorama->is_comment = $request->safe()->boolean('is_comment');
        $dorama->is_rating = $request->safe()->boolean('is_rating');

        try {
            DB::transaction(function () use ($dorama, $countries, $genres, $studios) {
                $dorama->save();

                $dorama->countries()->attach($countries);
                $dorama->genres()->attach($genres);
                $dorama->studios()->attach($studios);
            });

            return redirect()->route('admin.doramas.index')->with('message', "Дорама {$dorama->title_ru} добавлена.");
        } catch (\Exception $e) {

            if (! is_null($dorama->poster)) {
                Storage::disk(S3Enum::DORAMAS->value)->delete($dorama->poster);
            }

            if (! is_null($dorama->cover)) {
                Storage::disk(S3Enum::DORAMAS->value)->delete($dorama->cover);
            }

            return redirect()->back()->with('message', 'Ошибка выполнения транзакции.'.$e->getMessage());
        }
    }

    public function update(DoramaUpdateRequest $request, Model $dorama): RedirectResponse
    {
        if (request()->has('poster')) {
            $dorama->poster = (new PosterService)->setStorage(S3Enum::DORAMAS->value)->save() ?? $dorama->poster;
        }

        if (request()->has('cover')) {
            $dorama->cover = (new CoverService)->setStorage(S3Enum::DORAMAS->value)->save() ?? $dorama->cover;
        }

        $dorama->title_org = $request->safe()->input('title_org');
        $dorama->title_ru = $request->safe()->input('title_ru');
        $dorama->title_en = $request->safe()->input('title_en');

        $dorama->type_id = $request->safe()->input('type');

        $dorama->country_id = null;
        $countries = $request->safe()->input('countries') ?? null;

        $dorama->genre_id = null;
        $genres = $request->safe()->input('genres') ?? null;

        $dorama->studio_id = null;
        $studios = $request->safe()->input('studios') ?? null;

        $dorama->age_rating = $request->safe()->input('age_rating');
        $dorama->episodes_total = $request->safe()->input('episodes_total');
        $dorama->duration = $request->safe()->input('duration');
        $dorama->release = $request->safe()->input('release');
        $dorama->description = $request->safe()->input('description');
        $dorama->status = $request->safe()->input('status');

        $dorama->rating = 0;
        $dorama->count_assessments = 0;

        $dorama->is_comment = $request->safe()->boolean('is_comment');
        $dorama->is_rating = $request->safe()->boolean('is_rating');

        try {
            DB::transaction(function () use ($dorama, $countries, $genres, $studios) {
                $dorama->update();

                $dorama->countries()->sync($countries);
                $dorama->genres()->sync($genres);
                $dorama->studios()->sync($studios);
            });

            return redirect()->route('admin.doramas.index')->with('message', "Дорама {$dorama->title_ru} обновлена.");
        } catch (\Exception $e) {
            return redirect()->back()->with('message', 'Ошибка выполнения транзакции.'.$e);
        }
    }
}
