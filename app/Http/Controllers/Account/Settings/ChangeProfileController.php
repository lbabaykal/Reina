<?php

namespace App\Http\Controllers\Account\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\Settings\ChangeProfileRequest;
use App\Services\Image\AvatarService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Lang;

class ChangeProfileController extends Controller
{
    public function __invoke(ChangeProfileRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = $request->user();
        $user->name = $validated['name'];

        if ($request->has('avatar')) {
            $user->avatar = new AvatarService()->saveAvatar() ?? $user->avatar;
        }

        $user->save();

        return response()->json(Lang::get('reina.settings.change_profile_successful'));
    }
}
