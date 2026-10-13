#!/usr/bin/env bash
set -euo pipefail

mkdir -p bin src/Command

cat > composer.json <<'JSON'
{
    "name": "acme/importer",
    "type": "project",
    "require": {
        "php": ">=8.4.1",
        "symfony/console": "^8.1",
        "symfony/dependency-injection": "^8.1"
    },
    "autoload": {
        "psr-4": { "Acme\\Importer\\": "src/" }
    }
}
JSON

cat > composer.lock <<'JSON'
{
    "packages": [
        { "name": "symfony/console", "version": "v8.1.8" },
        { "name": "symfony/dependency-injection", "version": "v8.1.8" }
    ],
    "packages-dev": []
}
JSON

cat > bin/importer <<'PHP'
#!/usr/bin/env php
<?php

declare(strict_types=1);

use Acme\Importer\Command\ImportCommand;
use Symfony\Component\Console\Application;

require dirname(__DIR__).'/vendor/autoload.php';

$application = new Application('importer');
$application->addCommand(new ImportCommand());
$application->run();
PHP

cat > src/Command/ImportCommand.php <<'PHP'
<?php

declare(strict_types=1);

namespace Acme\Importer\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('import', 'Imports the products of a CSV file')]
final class ImportCommand
{
    public function __invoke(SymfonyStyle $io, #[Argument('CSV file')] string $file): int
    {
        $handle = fopen($file, 'r');
        while (false !== ($row = fgetcsv($handle))) {
            $io->writeln(implode(', ', $row));
        }
        fclose($handle);

        return Command::SUCCESS;
    }
}
PHP
