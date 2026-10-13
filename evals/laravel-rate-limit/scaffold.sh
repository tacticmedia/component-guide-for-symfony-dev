#!/usr/bin/env bash
set -euo pipefail
mkdir -p routes app/Http/Controllers
printf '{\n    "name": "acme/shop",\n    "type": "project",\n    "require": {\n        "php": "^8.4",\n        "laravel/framework": "^13.0"\n    }\n}\n' > composer.json
printf '#!/usr/bin/env php\n<?php\n// Laravel artisan entry point\n' > artisan
cat > routes/web.php <<'PHP'
<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [LoginController::class, 'store'])->name('login');
PHP
