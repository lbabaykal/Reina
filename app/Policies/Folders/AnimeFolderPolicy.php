<?php

namespace App\Policies\Folders;

use App\Models\AnimeFolder;
use App\Models\User;
use App\Reina;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Lang;

class AnimeFolderPolicy
{
    public function viewAny(User $user): Response
    {
        return Response::denyWithStatus(403);
    }

    public function view(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === 0
            || $folderAnime->user_id === $user->id
            || $folderAnime->is_private)
            ? Response::allow()
            : Response::deny(['message' => Lang::get('reina.folder.not_permission_view')]);
    }

    public function create(User $user): Response
    {
        $countFolders = $user->animeFolders()->count();

        return ($countFolders < Reina::COUNT_FOLDERS)
            ? Response::allow()
            : Response::deny(['message' => Lang::get('reina.folder.limit')]);
    }

    public function update(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === $user->id)
            ? Response::allow()
            : Response::deny(['message' => Lang::get('reina.folder.is_not_yours')]);
    }

    public function delete(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === $user->id)
            ? Response::allow()
            : Response::deny(['message' => Lang::get('reina.folder.is_not_yours')]);
    }
}
