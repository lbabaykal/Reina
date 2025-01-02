<?php

if (! function_exists('getIdFromSlug')) {
    function getIdFromSlug(string $slug = ''): ?int
    {
        preg_match('/^\d+/', $slug, $matches);
        return $matches[0] ?? null;
    }
}
