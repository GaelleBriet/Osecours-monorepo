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

    //'allowed_origins' => ['http://localhost:5173'], // Allowed origins

    'allowed_origins' => [
        'https://www.osecours-asso.fr',
        'https://osecours-front-eu-851bfe93cb8c.herokuapp.com',
        'https://my-cors-app-93d3e802d505.herokuapp.com',
        'https://my-cors-app-93d3e802d505.herokuapp.com/https://osecours-front-eu-851bfe93cb8c.herokuapp.com',
        'https://my-cors-app-93d3e802d505.herokuapp.com/https://osecours-api-eu-fb28aa2da721.herokuapp.com',
        'https://my-cors-app-93d3e802d505.herokuapp.com/https://osecours-api-eu-fb28aa2da721.herokuapp.com/api'
    ],

    'allowed_origins_patterns' => [], // Patterns for matching origins

    'allowed_headers' => ['*'], // Headers allowed in requests 'Content-Type', 'X-Requested-With'

    'exposed_headers' => [], // Headers exposed in responses 'Authorization', 'X-Custom-Header'

    'max_age' => 86400, // Max age for the preflight request (in seconds)

    'supports_credentials' => true, // Whether credentials are supported

];
