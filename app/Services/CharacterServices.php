<?php

namespace App\Services;

use App\Enums\CacheEnum;
use App\Enums\StatusEnum;
use App\Http\Requests\AdminPanel\CharacterStoreRequest;
use App\Http\Requests\AdminPanel\CharacterUpdateRequest;
use App\Models\Anime;
use App\Models\Character;
use App\Services\Image\PhotoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class CharacterServices
{
    public function store(CharacterStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $character = new Character;
        $character->photo = new PhotoService()->saveForCharacter();
        $character->full_name_org = $validated['full_name_org'];
        $character->full_name_ru = $validated['full_name_ru'];
        $character->full_name_en = $validated['full_name_en'];
        $character->description = $validated['description'];
        $character->save();

        return redirect()->route('admin.characters.index')->with('message', "Персонаж {$character->full_name_ru} добавлен.");
    }

    public function update(CharacterUpdateRequest $request, Model $character): RedirectResponse
    {
        $validated = $request->validated();

        if (request()->has('photo')) {
            $character->photo = new PhotoService()->saveForCharacter() ?? $character->photo;
        }

        $character->full_name_org = $validated['full_name_org'];
        $character->full_name_ru = $validated['full_name_ru'];
        $character->full_name_en = $validated['full_name_en'];
        $character->description = $validated['description'];
        $character->save();

        return redirect()->route('admin.characters.index')->with('message', "Персонаж {$character->full_name_ru} обновлён.");
    }

    public function destroy(Model $character): RedirectResponse
    {
        $character->delete();

        return redirect()->route('admin.characters.index')->with('message', "Персонаж {$character->full_name_ru} удалён.");
    }

    public function charactersForAnimeById(int $id)
    {
        $anime = Anime::query()
            ->select(['id'])
            ->findOrFail($id);

        return cache()->store(CacheEnum::DIFFERENT_STORE->value)
            ->flexible(CacheEnum::ANIME_CHARACTERS->value.$id, [1200, 1800], function () use ($anime) {
                return $anime->characters()
                    ->select(['characters.id', 'characters.slug', 'characters.full_name_org', 'characters.full_name_ru', 'characters.full_name_en', 'characters.photo'])
                    ->get();
            });
    }
}
