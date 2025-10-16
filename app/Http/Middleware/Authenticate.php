<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * إعادة التوجيه إذا المستخدم غير مسجّل الدخول
     */
    protected function redirectTo(Request $request): ?string
    {
        // ✅ لو الطلب مش JSON، رجعه لصفحة الأدمن
        if (! $request->expectsJson()) {
            return route('admin.login');
        }

        return null;
    }
}
