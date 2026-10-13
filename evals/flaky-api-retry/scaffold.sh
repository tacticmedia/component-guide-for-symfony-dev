#!/usr/bin/env bash
set -euo pipefail
mkdir -p config src/Controller
cat > composer.json <<'JSON'
{
    "name": "acme/shop",
    "type": "project",
    "require": {
        "php": ">=8.4.1",
        "symfony/console": "^8.1",
        "symfony/framework-bundle": "^8.1",
        "symfony/http-client": "^8.1",
        "symfony/messenger": "^8.1",
        "symfony/runtime": "^8.1"
    },
    "autoload": { "psr-4": { "App\\": "src/" } }
}
JSON
cat > composer.lock <<'JSON'
{
    "packages": [
        { "name": "symfony/console", "version": "v8.1.8" },
        { "name": "symfony/framework-bundle", "version": "v8.1.8" },
        { "name": "symfony/http-client", "version": "v8.1.8" },
        { "name": "symfony/messenger", "version": "v8.1.8" },
        { "name": "symfony/runtime", "version": "v8.1.8" }
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
