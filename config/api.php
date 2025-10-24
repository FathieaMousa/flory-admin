<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration settings for the Flory API endpoints
    |
    */

    'rate_limit' => env('API_RATE_LIMIT', 60),
    'timeout' => env('API_TIMEOUT', 30),
    
    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Firebase integration
    |
    */
    
    'firebase' => [
        'project_id' => env('FIREBASE_PROJECT_ID', 'fire-app-d3181'),
        'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', 'fire-app-d3181.firebasestorage.app'),
    ],

    /*
    |--------------------------------------------------------------------------
    | CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Allowed origins for CORS requests
    |
    */
    
    'allowed_origins' => [
        env('APP_URL', 'http://localhost:8000'),
        'http://localhost:3000',
        'https://your-flutter-app-domain.com', // Update this for production
    ],

];
