<?php

namespace App\Enums;

enum CacheEnum: string
{
    case FRANCHISE = 'franchise:';
    case DIFFERENT_STORE = 'redis_different';

    case ANIMES_STORE = 'redis_animes';
    case MAIN_ANIMES = 'main_animes';
    case ANIME = 'anime:';
    case ANIME_EPISODES = 'anime_episodes:';

    case DORAMAS_STORE = 'redis_doramas';
    case MAIN_DORAMAS = 'main_doramas';
    case DORAMA = 'dorama:';
    case DORAMAS_EPISODES = 'dorama_episodes:';

}
