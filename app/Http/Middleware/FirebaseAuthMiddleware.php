<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Kreait\Firebase\Auth;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Factory;
use App\Helpers\ApiLogger;
use App\Helpers\SentryHelper;

class FirebaseAuthMiddleware
{
    protected $auth;

    public function __construct()
    {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $this->auth = $factory->createAuth();
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization token not provided'
            ], 401);
        }

        try {
            // Verify the Firebase token
            $verifiedToken = $this->auth->verifyIdToken($token);
            $uid = $verifiedToken->claims()->get('sub');

            // Log successful authentication
            ApiLogger::firebaseAuth('Token verified successfully', [
                'firebase_uid' => $uid,
                'endpoint' => $request->path(),
            ]);

            // Add user info to request for use in controllers
            $request->merge(['firebase_uid' => $uid]);
            $request->merge(['firebase_user' => $verifiedToken]);

            return $next($request);

        } catch (AuthException $e) {
            // Log authentication failure
            ApiLogger::firebaseAuth('Token verification failed', [
                'error' => $e->getMessage(),
                'endpoint' => $request->path(),
            ]);

            // Report to Sentry
            SentryHelper::captureFirebaseAuthError('Firebase token verification failed', [
                'error' => $e->getMessage(),
                'endpoint' => $request->path(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired token',
                'error' => $e->getMessage()
            ], 401);
        } catch (\Exception $e) {
            // Report to Sentry
            SentryHelper::captureException($e, [
                'endpoint' => $request->path(),
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Token verification failed',
                'error' => $e->getMessage()
            ], 401);
        }
    }
}
