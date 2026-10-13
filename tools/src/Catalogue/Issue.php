<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class Issue
{
    public function __construct(
        public bool $isError,
        public string $file,
        public string $message,
    ) {
    }

    public static function error(string $file, string $message): self
    {
        return new self(true, $file, $message);
    }

    public static function warning(string $file, string $message): self
    {
        return new self(false, $file, $message);
    }
}
