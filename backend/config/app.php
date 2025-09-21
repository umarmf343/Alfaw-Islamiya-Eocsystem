<?php

use Illuminate\Support\ServiceProvider;

return [
    'name' => env('APP_NAME', 'AlFawz'),
    'env' => env('APP_ENV', 'production'),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'fallback_locale' => 'en',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'providers' => ServiceProvider::defaultProviders()
        ->merge(require __DIR__.'/../bootstrap/providers.php')
        ->toArray(),
];
