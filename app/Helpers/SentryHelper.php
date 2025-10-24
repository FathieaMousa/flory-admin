<?php

namespace App\Helpers;

use Sentry\State\Scope;

class SentryHelper
{
    /**
     * Capture exception with custom context
     */
    public static function captureException(\Throwable $exception, array $context = []): void
    {
        \Sentry\withScope(function (Scope $scope) use ($exception, $context) {
            foreach ($context as $key => $value) {
                $scope->setContext($key, $value);
            }
            \Sentry\captureException($exception);
        });
    }

    /**
     * Capture message with custom context
     */
    public static function captureMessage(string $message, array $context = [], string $level = 'info'): void
    {
        \Sentry\withScope(function (Scope $scope) use ($message, $context, $level) {
            foreach ($context as $key => $value) {
                $scope->setContext($key, $value);
            }
            \Sentry\captureMessage($message, $level);
        });
    }

    /**
     * Capture API error with context
     */
    public static function captureApiError(string $message, array $context = []): void
    {
        self::captureMessage($message, array_merge($context, [
            'type' => 'api_error',
            'timestamp' => now()->toISOString(),
        ]), 'error');
    }

    /**
     * Capture Firebase authentication error
     */
    public static function captureFirebaseAuthError(string $message, array $context = []): void
    {
        self::captureMessage($message, array_merge($context, [
            'type' => 'firebase_auth_error',
            'timestamp' => now()->toISOString(),
        ]), 'error');
    }

    /**
     * Capture database error
     */
    public static function captureDatabaseError(string $message, array $context = []): void
    {
        self::captureMessage($message, array_merge($context, [
            'type' => 'database_error',
            'timestamp' => now()->toISOString(),
        ]), 'error');
    }

    /**
     * Capture cache error
     */
    public static function captureCacheError(string $message, array $context = []): void
    {
        self::captureMessage($message, array_merge($context, [
            'type' => 'cache_error',
            'timestamp' => now()->toISOString(),
        ]), 'warning');
    }

    /**
     * Add user context to Sentry
     */
    public static function setUserContext(array $userData): void
    {
        \Sentry\configureScope(function (Scope $scope) use ($userData) {
            $scope->setUser($userData);
        });
    }

    /**
     * Add custom tags to Sentry
     */
    public static function setTags(array $tags): void
    {
        \Sentry\configureScope(function (Scope $scope) use ($tags) {
            foreach ($tags as $key => $value) {
                $scope->setTag($key, $value);
            }
        });
    }
}
