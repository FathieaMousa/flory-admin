<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * ✅ هذا الكود يتعامل مع الطلبات غير الموثقة (Unauthorized)
     * إذا الطلب من API → يرجع JSON
     * إذا من الويب → يرجع صفحة تسجيل الأدمن
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => false,
                'message' => '🚫 Unauthorized: يرجى تسجيل الدخول أولاً.'
            ], 401);
        }

        return redirect()->guest(route('admin.login'));
    }
}
