<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Specify paths where CORS should be applied

    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], // HTTP methods allowed

    'allowed_origins' => ['https://osecours-asso.fr', 'https://www.osecours-asso.fr', '109.176.198.68', 'http://localhost:8000', 'http://localhost:5173'], // Allowed origins

    'allowed_origins_patterns' => [], // Patterns for matching origins

    'allowed_headers' => ['*'], // Headers allowed in requests 'Content-Type', 'X-Requested-With'

    'exposed_headers' => [], // Headers exposed in responses 'Authorization', 'X-Custom-Header'

    'max_age' => 86400, // Max age for the preflight request (in seconds)

    'supports_credentials' => true, // Whether credentials are supported

];
