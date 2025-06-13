<?php

declare(strict_types=1);

use App\Reina;

return [
    'anime' => [
        'rating_store' => 'Anime rating added.',
        'rating_update' => 'Anime rating updated.',
        'rating_destroy' => 'Anime rating removed.',
        'rating_forbidden' => 'Cannot rate anime.',
        'favorite_store' => 'Anime added to favorites.',
        'favorite_update' => 'Anime updated in favorites.',
        'favorite_destroy' => 'Anime removed from favorites.',
        'favorite_change_episode' => 'Favorite episode updated.',
    ],
    'dorama' => [
        'rating_store' => 'Dorama rating added.',
        'rating_update' => 'Dorama rating updated.',
        'rating_destroy' => 'Dorama rating removed.',
        'rating_forbidden' => 'Cannot rate dorama.',
        'favorite_store' => 'Dorama added to favorites.',
        'favorite_update' => 'Dorama updated in favorites.',
        'favorite_destroy' => 'Dorama removed from favorites.',
        'favorite_change_episode' => 'Favorite episode updated.',
    ],
    'folder' => [
        'created' => 'Folder :title successfully created.',
        'updated' => 'Folder :title successfully updated.',
        'deleted' => 'Folder :title successfully deleted.',
        'not_permission_view' => 'You do not have permission to view this folder.',
        'is_not_yours' => 'You are not the owner of this folder.',
        'limit' => 'Cannot create more than '.Reina::COUNT_FOLDERS.' folders.',
    ],
    'enum' => [
        'status' => [
            'published' => 'Опубликовано',
            'draft' => 'Черновик',
            'in_archive' => 'В архиве',
            'on_moderation' => 'На модерации',
        ],
        'types_episode' => [
            'voiceover' => 'Озвучка',
            'dubbing' => 'Дубляж',
            'subtitles' => 'Субтитры',
        ],
    ],
];
