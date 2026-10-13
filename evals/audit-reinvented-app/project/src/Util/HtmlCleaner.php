<?php

namespace App\Util;

final class HtmlCleaner
{
    private const string ALLOWED_TAGS = '<p><a><strong><em><ul><ol><li><br>';

    public static function cleanComment(string $html): string
    {
        $html = strip_tags($html, self::ALLOWED_TAGS);
        $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html);

        return (string) preg_replace('/href\s*=\s*(["\'])\s*javascript:[^"\']*\1/i', 'href="#"', (string) $html);
    }
}
