<?php

namespace App\Util;

final class Slugger
{
    public static function slugify(string $title): string
    {
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $title);
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower((string) $ascii));

        return trim((string) $slug, '-');
    }
}
