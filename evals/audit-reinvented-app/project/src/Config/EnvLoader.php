<?php

namespace App\Config;

final class EnvLoader
{
    public static function load(string $path): void
    {
        if (!is_file($path)) {
            return;
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) {
                continue;
            }
            [$name, $value] = explode('=', $line, 2);
            $name = trim($name);
            if (false === getenv($name)) {
                putenv($name.'='.trim($value, " \"'"));
                $_ENV[$name] = trim($value, " \"'");
            }
        }
    }
}
