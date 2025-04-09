<?php

use Illuminate\Support\Facades\Lang;

if (! function_exists('getIdFromSlug')) {
    function getIdFromSlug(string $slug): int
    {
        preg_match('/^\d+/', $slug, $matches);

        if (empty($matches)) {
            abort(404, Lang::get('http-statuses.404'));
        }

        return (int) $matches[0];
    }
}
