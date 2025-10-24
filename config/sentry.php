<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sentry DSN
    |--------------------------------------------------------------------------
    |
    | The Sentry DSN is a URL that tells the Sentry SDK where to send events.
    | You can find this in your Sentry project settings.
    |
    */
    'dsn' => env('SENTRY_LARAVEL_DSN', env('SENTRY_DSN')),

    /*
    |--------------------------------------------------------------------------
    | Sentry Environment
    |--------------------------------------------------------------------------
    |
    | The environment that will be sent with each event. This helps you
    | filter events in the Sentry interface.
    |
    */
    'environment' => env('SENTRY_ENVIRONMENT', env('APP_ENV', 'production')),

    /*
    |--------------------------------------------------------------------------
    | Sentry Release
    |--------------------------------------------------------------------------
    |
    | The release version of your application. This helps you track which
    | version of your application generated an error.
    |
    */
    'release' => env('SENTRY_RELEASE'),

    /*
    |--------------------------------------------------------------------------
    | Sentry Sample Rate
    |--------------------------------------------------------------------------
    |
    | The sample rate for performance monitoring. Set to 0.0 to disable
    | performance monitoring, or 1.0 to capture all transactions.
    |
    */
    'sample_rate' => env('SENTRY_SAMPLE_RATE', 0.1),

    /*
    |--------------------------------------------------------------------------
    | Sentry Traces Sample Rate
    |--------------------------------------------------------------------------
    |
    | The sample rate for distributed tracing. Set to 0.0 to disable
    | distributed tracing, or 1.0 to capture all traces.
    |
    */
    'traces_sample_rate' => env('SENTRY_TRACES_SAMPLE_RATE', 0.1),

    /*
    |--------------------------------------------------------------------------
    | Sentry Breadcrumbs
    |--------------------------------------------------------------------------
    |
    | Breadcrumbs are a trail of events that happened before an issue.
    | Set to true to enable breadcrumbs.
    |
    */
    'breadcrumbs' => [
        'sql_queries' => true,
        'sql_bindings' => true,
        'logs' => true,
        'cache' => true,
        'queue' => true,
        'http_client_requests' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Sentry User Context
    |--------------------------------------------------------------------------
    |
    | Set to true to automatically capture user context from the authenticated
    | user.
    |
    */
    // 'user_context' => true, // Commented out due to compatibility issues

    /*
    |--------------------------------------------------------------------------
    | Sentry Tags
    |--------------------------------------------------------------------------
    |
    | Additional tags to send with each event.
    |
    */
    'tags' => [
        'php_version' => PHP_VERSION,
        'laravel_version' => app()->version(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sentry Ignored Exceptions
    |--------------------------------------------------------------------------
    |
    | List of exceptions that should not be sent to Sentry.
    |
    */
    'ignore_exceptions' => [
        // Add exceptions you want to ignore here
    ],

    /*
    |--------------------------------------------------------------------------
    | Sentry Ignored Transactions
    |--------------------------------------------------------------------------
    |
    | List of transactions that should not be sent to Sentry.
    |
    */
    'ignore_transactions' => [
        // Add transactions you want to ignore here
    ],

];
