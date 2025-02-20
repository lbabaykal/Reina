<?php

namespace App\Policies\Folders;

use App\Models\AnimeFolder;
use App\Models\User;
use App\Reina;
use Illuminate\Auth\Access\Response;

class FolderAnimePolicy
{
    public function viewAny(User $user): Response
    {
        return Response::denyWithStatus(403);
    }

    public function view(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === 0 || $folderAnime->user_id === $user->id)
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function create(User $user): Response
    {
        $countFolders = $user->animeFolders()->count();

        return ($countFolders < Reina::COUNT_FOLDERS)
            ? Response::allow()
            : Response::deny('Нельзя создавать больше ' . Reina::COUNT_FOLDERS . ' папок.', 403);
    }

    public function update(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === $user->id)
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

    public function delete(User $user, AnimeFolder $folderAnime): Response
    {
        return ($folderAnime->user_id === $user->id)
            ? Response::allow()
            : Response::denyWithStatus(403);
    }

}
