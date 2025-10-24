<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Basic Information
    |--------------------------------------------------------------------------
    |
    | The basic information about your API. These will be used to generate
    | the documentation.
    |
    */

    'title' => 'Flory E-Commerce API',
    'description' => 'API documentation for Flory flower shop mobile application and admin dashboard.',
    'base_url' => env('APP_URL', 'http://localhost:8000'),
    'routes' => [
        /*
        |--------------------------------------------------------------------------
        | Specify which routes to document
        |--------------------------------------------------------------------------
        |
        | You can specify routes to document by specifying patterns or exact routes.
        |
        */
        'include' => [
            'api/*',
        ],

        /*
        |--------------------------------------------------------------------------
        | Exclude routes from documentation
        |--------------------------------------------------------------------------
        |
        | You can exclude routes from documentation by specifying patterns or exact routes.
        |
        */
        'exclude' => [
            'api/docs/*',
            'api/clear-cache/*',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Type
    |--------------------------------------------------------------------------
    |
    | The type of documentation to generate. Can be 'static' or 'laravel'.
    |
    */
    'type' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | Settings for static documentation
    |--------------------------------------------------------------------------
    |
    | Settings for generating static documentation files.
    |
    */
    'static' => [
        'output_path' => 'public/docs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Settings for Laravel documentation
    |--------------------------------------------------------------------------
    |
    | Settings for generating Laravel documentation.
    |
    */
    'laravel' => [
        'add_routes' => true,
        'docs_url' => '/api/docs',
        'middleware' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | Postman collection
    |--------------------------------------------------------------------------
    |
    | Settings for generating Postman collection.
    |
    */
    'postman' => [
        'enabled' => true,
        'overrides' => [
            'info.version' => '1.0.0',
            'info.name' => 'Flory E-Commerce API',
            'info.description' => 'API collection for Flory flower shop application',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | OpenAPI specification
    |--------------------------------------------------------------------------
    |
    | Settings for generating OpenAPI specification.
    |
    */
    'openapi' => [
        'enabled' => true,
        'overrides' => [
            'info.version' => '1.0.0',
            'info.title' => 'Flory E-Commerce API',
            'info.description' => 'API specification for Flory flower shop application',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    |
    | Group your API routes. Groups are used to organize your API documentation.
    |
    */
    'groups' => [
        [
            'title' => 'Authentication',
            'description' => 'Authentication endpoints for user login, registration, and profile management.',
            'routes' => ['auth/*'],
        ],
        [
            'title' => 'Products',
            'description' => 'Product catalog endpoints for browsing and viewing products.',
            'routes' => ['products/*'],
        ],
        [
            'title' => 'Categories',
            'description' => 'Product categories endpoints for browsing categories.',
            'routes' => ['categories/*'],
        ],
        [
            'title' => 'Orders',
            'description' => 'Order management endpoints for creating and tracking orders.',
            'routes' => ['orders/*'],
        ],
        [
            'title' => 'Addresses',
            'description' => 'User address management endpoints.',
            'routes' => ['addresses/*'],
        ],
        [
            'title' => 'Notifications',
            'description' => 'Push notification endpoints.',
            'routes' => ['notifications/*'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    |
    | Configure authentication for your API documentation.
    |
    */
    'auth' => [
        'enabled' => true,
        'default' => 'firebase',
        'in' => 'bearer',
        'name' => 'Authorization',
        'use_value' => 'Bearer {your-firebase-token}',
        'placeholder' => '{your-firebase-token}',
        'extra_info' => 'Get your Firebase token from the Flutter app after authentication.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Response calls
    |--------------------------------------------------------------------------
    |
    | Configure how responses are generated.
    |
    */
    'response_calls' => [
        'enabled' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Try it out
    |--------------------------------------------------------------------------
    |
    | Configure the "Try it out" feature.
    |
    */
    'try_it_out' => [
        'enabled' => true,
    ],
];
