<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class ApiLogger
{
    /**
     * Log API errors with context
     */
    public static function error(string $message, array $context = [], ?string $endpoint = null): void
    {
        Log::channel('api')->error($message, array_merge($context, [
            'endpoint' => $endpoint,
            'timestamp' => now()->toISOString(),
        ]));
    }

    /**
     * Log API warnings with context
     */
    public static function warning(string $message, array $context = [], ?string $endpoint = null): void
    {
        Log::channel('api')->warning($message, array_merge($context, [
            'endpoint' => $endpoint,
            'timestamp' => now()->toISOString(),
        ]));
    }

    /**
     * Log API info with context
     */
    public static function info(string $message, array $context = [], ?string $endpoint = null): void
    {
        Log::channel('api')->info($message, array_merge($context, [
            'endpoint' => $endpoint,
            'timestamp' => now()->toISOString(),
        ]));
    }

    /**
     * Log Firebase authentication events
     */
    public static function firebaseAuth(string $event, array $context = []): void
    {
        Log::channel('api')->info("Firebase Auth: {$event}", array_merge($context, [
            'event_type' => 'firebase_auth',
            'timestamp' => now()->toISOString(),
        ]));
    }

    /**
     * Log cache events
     */
    public static function cacheEvent(string $event, array $context = []): void
    {
        Log::channel('api')->info("Cache Event: {$event}", array_merge($context, [
            'event_type' => 'cache',
            'timestamp' => now()->toISOString(),
        ]));
    }

    /**
     * Log database query performance
     */
    public static function queryPerformance(string $query, float $duration, array $context = []): void
    {
        Log::channel('api')->info("Query Performance", array_merge($context, [
            'query' => $query,
            'duration_ms' => round($duration * 1000, 2),
            'event_type' => 'query_performance',
            'timestamp' => now()->toISOString(),
        ]));
    }
}
