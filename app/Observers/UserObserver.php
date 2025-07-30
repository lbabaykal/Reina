<?php

namespace App\Observers;

use App\Models\User;
use App\Services\Image\AvatarService;

class UserObserver
{

    public function updating(User $user): void
    {
        if ($user->isDirty('avatar') && $user->getOriginal('avatar')) {
            new AvatarService()->deleteAvatar($user->getOriginal('avatar'));
        }
    }

    public function deleted(User $user): void
    {
        if ($user->avatar !== null) {
            new AvatarService()->deleteAvatar($user->avatar);
        }
    }
}
