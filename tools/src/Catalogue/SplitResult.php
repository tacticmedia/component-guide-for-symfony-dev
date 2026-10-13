<?php

declare(strict_types=1);

namespace ComponentGuide\Tools\Catalogue;

final readonly class SplitResult
{
    public function __construct(
        public string $triage,
        public string $details,
        public string $verifiedAgainst,
    ) {
    }
}
