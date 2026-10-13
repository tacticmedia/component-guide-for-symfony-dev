<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class Section
{
    public function __construct(
        public string $heading,
        public string $body,
    ) {
    }
}
