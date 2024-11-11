<?php

if (! function_exists('getIdFromSlug')) {
    function getIdFromSlug(string $slug = ''): ?int
    {
        preg_match('/^\d+/', $slug, $matches);
        return $matches[0] ?? null;
    }
}

if (! function_exists('imageService')) {

    function imageService(): \App\Services\Image\ImageService
    {
        return new \App\Services\Image\ImageService();
    }
}

