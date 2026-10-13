#!/usr/bin/env bash
set -euo pipefail
mkdir -p config src/Controller
cat > composer.json <<'JSON'
{
    "name": "acme/shop",
    "type": "project",
    "require": {
        "php": ">=8.4.1",
        "symfony/console": "^8.0",
        "symfony/framework-bundle": "^8.0",
        "symfony/runtime": "^8.0"
    },
    "autoload": { "psr-4": { "App\\": "src/" } }
}
JSON
cat > composer.lock <<'JSON'
{
    "packages": [
        { "name": "symfony/console", "version": "v8.0.13" },
        { "name": "symfony/framework-bundle", "version": "v8.0.13" },
        { "name": "symfony/runtime", "version": "v8.0.13" }
    ],
    "packages-dev": []
}
JSON
cat > config/bundles.php <<'PHP'
<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
];
PHP
cat > src/Kernel.php <<'PHP'
<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
}
PHP
mkdir -p src/Command
cat > src/Command/ReportCommand.php <<'PHP'
<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('app:report', 'Prints the daily sales report')]
final class ReportCommand
{
    public function __invoke(SymfonyStyle $io, #[Option('Print totals only')] bool $totals = false): int
    {
        $io->success($totals ? 'Total: 42' : 'Report: 42 orders');

        return Command::SUCCESS;
    }
}
PHP
