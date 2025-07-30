<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Http\Requests\AdminPanel\PersonStoreRequest;
use App\Http\Requests\AdminPanel\PersonUpdateRequest;
use App\Models\Anime;
use App\Models\Dorama;
use App\Models\Person;
use App\Services\Image\PhotoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class PersonServices
{
    public function store(PersonStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $person = new Person;
        $person->photo = new PhotoService()->saveForPerson();
        $person->full_name_org = $validated['full_name_org'];
        $person->full_name_ru = $validated['full_name_ru'];
        $person->full_name_en = $validated['full_name_en'];
        $person->date_of_birth = $validated['date_of_birth'];
        $person->description = $validated['description'];
        $person->save();

        return redirect()->route('admin.persons.index')->with('message', "Персона {$person->full_name_ru} добавлена.");
    }

    public function update(PersonUpdateRequest $request, Model $person): RedirectResponse
    {
        $validated = $request->validated();

        if (request()->has('photo')) {
            $person->photo = new PhotoService()->saveForPerson() ?? $person->photo;
        }

        $person->full_name_org = $validated['full_name_org'];
        $person->full_name_ru = $validated['full_name_ru'];
        $person->full_name_en = $validated['full_name_en'];
        $person->date_of_birth = $validated['date_of_birth'];
        $person->description = $validated['description'];
        $person->save();

        return redirect()->route('admin.persons.index')->with('message', "Персона {$person->full_name_ru} обновлена.");
    }

    public function destroy(Model $person): RedirectResponse
    {
        $person->delete();

        return redirect()->route('admin.persons.index')->with('message', "Персона {$person->full_name_ru} удалена.");
    }

    public function personsForAnimeById(int $id)
    {
        $anime = Anime::query()
            ->select(['id'])
            ->findOrFail($id);

        return cache()->store(CacheEnum::DIFFERENT_STORE->value)
            ->flexible(CacheEnum::ANIME_PERSONS->value.$id, [1200, 1800], function () use ($anime) {
                return $anime->persons()
                    ->with([
                        'person:id,slug,full_name_org,full_name_ru,full_name_en,photo',
                        'personRole:id,slug',
                    ])
                    ->get();
            });
    }

    public function personsForDoramaById(int $id)
    {
        $dorama = Dorama::query()
            ->select(['id'])
            ->findOrFail($id);

        return cache()->store(CacheEnum::DIFFERENT_STORE->value)
            ->flexible(CacheEnum::DORAMAS_PERSONS->value.$id, [1200, 1800], function () use ($dorama) {
                return $dorama->persons()
                    ->with([
                        'person:id,slug,full_name_org,full_name_ru,full_name_en,photo',
                        'personRole:id,slug',
                    ])
                    ->get();
            });
    }
}
