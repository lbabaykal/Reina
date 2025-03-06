<?php

namespace App\Policies;

use App\Models\Anime;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Lang;

class AnimePolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Anime $anime): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Anime $anime): bool
    {
        return false;
    }

    public function delete(User $user, Anime $anime): bool
    {
        return false;
    }

    public function restore(User $user, Anime $anime): bool
    {
        return false;
    }

    public function forceDelete(User $user, Anime $anime): bool
    {
        return false;
    }

    public function isRating(User $user, Anime $anime): Response
    {
        return ($anime->is_rating)
            ? Response::allow()
            : Response::deny(Lang::get('reina.anime.rating_forbidden'));
    }
}
