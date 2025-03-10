<?php

declare(strict_types=1);

use App\Reina;

return [
    'anime' => [
        'rating_store' => 'Оценка к аниме добавлена.',
        'rating_update' => 'Оценка к аниме обновлена.',
        'rating_destroy' => 'Оценка к аниме удалена.',
        'rating_forbidden' => 'Нельзя оценивать аниме.',
        'favorite_store' => 'Аниме добавлено в избранное.',
        'favorite_update' => 'Аниме обновлено в избранном.',
        'favorite_destroy' => 'Аниме удалено из избранного.',
        'favorite_change_episode' => 'Избранный эпизод обновлён.',
    ],
    'dorama' => [
        'rating_store' => 'Оценка к дораме добавлена.',
        'rating_update' => 'Оценка к дораме обновлена.',
        'rating_destroy' => 'Оценка к дораме удалена.',
        'rating_forbidden' => 'Нельзя оценивать дораму.',
        'favorite_store' => 'Дорама добавлена в избранное.',
        'favorite_update' => 'Дорама обновлена в избранном.',
        'favorite_destroy' => 'Дорама удалена из избранного.',
        'favorite_change_episode' => 'Избранный эпизод обновлён.',
    ],
    'folder' => [
        'created' => 'Папка :title успешно создана.',
        'updated' => 'Папка :title успешно обновлена.',
        'deleted' => 'Папка :title успешно удалена.',
        'not_permission_view' => 'У вас нет прав на просмотр этой папки.',
        'is_not_yours' => 'Вы не являетесь владельцем этой папки.',
        'limit' => 'Нельзя создавать больше '.Reina::COUNT_FOLDERS.' папок.',
    ],
];
