<?php

namespace App\Enums;

enum CacheEnum: string
{
    case MAIN_ANIMES = 'main_animes:';
    case ANIME = 'anime:';
    case ANIME_WATCH = 'anime_watch:';


    case MAIN_DORAMAS = 'main_doramas:';
    case DORAMA = 'dorama:';
    case DORAMA_WATCH = 'dorama_watch:';

}
