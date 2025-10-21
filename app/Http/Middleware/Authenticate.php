<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * يحدد ما يجب فعله إذا المستخدم غير مصدّق (لم يسجل الدخول)
     */
    protected function redirectTo(Request $request): ?string
    {
        // ✅ إذا الطلب ليس من نوع JSON (أي من الويب)
        if (! $request->expectsJson()) {
            return route('admin.login');
        }

        // ✅ إذا الطلب من API (مثل Postman أو Flutter)
        return null;
    }
}
