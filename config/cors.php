<?php

/*
 |--------------------------------------------------------------------------
 | Studio API CORS Origins
 |--------------------------------------------------------------------------
 |
 | The browser origins allowed to call the Studio API. Values come from the
 | STUDIO_ALLOWED_ORIGINS environment variable as a comma-separated list, so
 | local development (localhost:5173) and production can be configured per
 | environment without hard-coding any domain.
 |
 */

$allowedOrigins = array_values(array_filter(array_map(
    'trim',
    explode(',', (string) env('STUDIO_ALLOWED_ORIGINS', 'https://studio.flowsee.ir,http://localhost:5173'))
)));

return [
    'paths' => ['api/studio/*'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
    'allowed_origins' => $allowedOrigins,
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['Accept', 'Authorization', 'Content-Type'],
    'exposed_headers' => [],
    'max_age' => 600,
    'supports_credentials' => false,
];
