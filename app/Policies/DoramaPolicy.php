<?php

namespace App\Policies;

use App\Models\Dorama;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Lang;

class DoramaPolicy
{

    public function viewAny(User $user): bool
    {
        return false;
    }

    public function view(User $user, Dorama $dorama): bool
    {
        return false;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Dorama $dorama): bool
    {
        return false;
    }

    public function delete(User $user, Dorama $dorama): bool
    {
        return false;
    }

    public function restore(User $user, Dorama $dorama): bool
    {
        return false;
    }

    public function forceDelete(User $user, Dorama $dorama): bool
    {
        return false;
    }

    public function isRating(User $user, Dorama $dorama): Response
    {
        return ($dorama->is_rating)
            ? Response::allow()
            : Response::deny(['message' => Lang::get('reina.dorama.rating_forbidden')]);
    }
}
