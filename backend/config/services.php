<?php

return [
    'paystack' => [
        'public_key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret_key' => env('PAYSTACK_SECRET_KEY'),
        'webhook_secret' => env('PAYSTACK_WEBHOOK_SECRET'),
    ],

    'openai' => [
        'key' => env('WHISPER_API_KEY'),
        'whisper_model' => env('WHISPER_MODEL', 'whisper-1'),
    ],
];
