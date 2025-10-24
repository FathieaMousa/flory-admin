<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiLoggingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $startTime = microtime(true);
        
        // Log the incoming request
        Log::channel('api_requests')->info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'endpoint' => $request->path(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip(),
            'firebase_uid' => $request->get('firebase_uid'),
            'request_data' => $this->sanitizeRequestData($request),
            'timestamp' => now()->toISOString(),
        ]);

        $response = $next($request);

        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2); // Convert to milliseconds

        // Log the response
        Log::channel('api_requests')->info('API Response', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'endpoint' => $request->path(),
            'status_code' => $response->getStatusCode(),
            'duration_ms' => $duration,
            'firebase_uid' => $request->get('firebase_uid'),
            'response_size' => strlen($response->getContent()),
            'timestamp' => now()->toISOString(),
        ]);

        return $response;
    }

    /**
     * Sanitize request data to remove sensitive information
     */
    private function sanitizeRequestData(Request $request): array
    {
        $data = $request->all();
        
        // Remove sensitive fields
        $sensitiveFields = ['password', 'token', 'authorization', 'secret'];
        
        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '***';
            }
        }

        // Remove authorization header if present
        if ($request->hasHeader('Authorization')) {
            $data['authorization'] = 'Bearer ***';
        }

        return $data;
    }
}
