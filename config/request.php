<?php

return [
    'idempotency' => [
        'enabled' => env('IDEMPOTENCY_ENABLED', true),
        // Time to live for idempotency keys in seconds
        'cache_ttl' => env('IDEMPOTENCY_CACHE_TTL', 300),
        'cache_prefix' => env('IDEMPOTENCY_CACHE_PREFIX', 'idempotency_key:'),
        'header_name' => env('IDEMPOTENCY_HEADER_NAME', 'x-idempotency-key'),
    ],
];
