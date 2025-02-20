<?php

namespace App\Enums;

enum CacheEnum: string
{
    CASE ANIMES_STORE = 'redis_animes';
    case MAIN_ANIMES = 'main_animes';
    case ANIME = 'anime:';
    case ANIME_WATCH = 'anime_watch:';


    CASE DORAMAS_STORE = 'redis_doramas';
    case MAIN_DORAMAS = 'main_doramas';
    case DORAMA = 'dorama:';
    case DORAMA_WATCH = 'dorama_watch:';

}
