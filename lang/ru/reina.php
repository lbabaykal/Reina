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
        'favorite_update_error' => 'Ошибка обновления Аниме в избранном.',
        'favorite_destroy' => 'Аниме удалено из избранного.',
        'favorite_destroy_error' => 'Ошибка удаления Аниме из избранного.',
        'favorite_remember_episode' => 'Эпизод обновлён в избранном.',
        'favorite_forget_episode' => 'Эпизод удалён из избранного.',
    ],
    'dorama' => [
        'rating_store' => 'Оценка к дораме добавлена.',
        'rating_update' => 'Оценка к дораме обновлена.',
        'rating_destroy' => 'Оценка к дораме удалена.',
        'rating_forbidden' => 'Нельзя оценивать дораму.',
        'favorite_store' => 'Дорама добавлена в избранное.',
        'favorite_update' => 'Дорама обновлена в избранном.',
        'favorite_destroy' => 'Дорама удалена из избранного.',
        'favorite_remember_episode' => 'Эпизод обновлён в избранном.',
        'favorite_forget_episode' => 'Эпизод удалён из избранного.',
    ],
    'folder' => [
        'created' => 'Папка :title успешно создана.',
        'updated' => 'Папка :title успешно обновлена.',
        'deleted' => 'Папка :title успешно удалена.',
        'not_permission_view' => 'У вас нет прав на просмотр этой папки.',
        'is_not_yours' => 'Вы не являетесь владельцем этой папки.',
        'limit' => 'Нельзя создавать больше '.Reina::COUNT_FOLDERS.' папок.',
    ],
    'episode' => [
        'no_exists' => 'Такого эпизода не существует.',
    ],
    'sort' => [
        'by_update_date' => 'По дате обновления',
        'by_rating' => 'По рейтингу',
        'by_release_date_as' => 'По дате выхода ▲',
        'by_release_date_desc' => 'По дате выхода ▼',
    ],
    'role' => [
        'main' => 'Главный герой',
        'secondary' => 'Второстепенный герой',
        'episodic' => 'Эпизодический герой',
    ],
    'settings' => [
        'change_profile_successful' => 'Профиль успешно обновлен.',
        'change_password_successful' => 'Пароль успешно изменён.',
    ],

];
