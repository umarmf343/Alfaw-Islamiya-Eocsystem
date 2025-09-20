<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

return [
    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'stderr' => [
            'driver' => 'stderr',
            'level' => env('LOG_LEVEL', 'debug'),
            'formatter' => env('LOG_STDERR_FORMATTER'),
        ],

        'syslog' => [
            'driver' => 'syslog',
            'handler' => SyslogUdpHandler::class,
            'level' => env('LOG_LEVEL', 'debug'),
        ],

        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => ['stream' => 'php://stdout'],
            'level' => env('LOG_LEVEL', 'debug'),
        ],
    ],
];
