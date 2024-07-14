<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 检查用户是否已经通过身份验证
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 检查当前认证用户是否具有 admin 角色
        if (!Auth::user()->HasRole('admin')) {
            abort(403, 'Unauthorized action.');
        }
        return $next($request);
    }
}
