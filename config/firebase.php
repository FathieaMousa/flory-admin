<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Firebase Service Account Configuration
    |--------------------------------------------------------------------------
    |
    | This file defines your Firebase Admin SDK credentials and default
    | project settings for Authentication, Realtime Database, and Storage.
    |
    */

   'credentials' => [
    'file' => base_path('storage/app/firebase/flory-service-account.json'),
],

    /*
    |--------------------------------------------------------------------------
    | Firebase Project ID
    |--------------------------------------------------------------------------
    */
    'project_id' => env('FIREBASE_PROJECT_ID'),

    /*
    |--------------------------------------------------------------------------
    | Firebase Database URL
    |--------------------------------------------------------------------------
    */
    'database' => [
        'url' => env('FIREBASE_DATABASE_URL'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Firebase Storage Configuration
    |--------------------------------------------------------------------------
    */
    'storage' => [
        'default_bucket' => env('FIREBASE_STORAGE_BUCKET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    | Enable or disable Firebase-related logging.
    */
    'logging' => [
        'enabled' => false,
    ],
];
