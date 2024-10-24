<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
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
        $currentUrl = url()->current();
        if (!auth()->check()) {
            Session::put('redirect_url', $currentUrl);
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập để truy cập vào trang này!');
        }
        if (auth()->user()->role != 1) {
            Session::put('redirect_url', $currentUrl);
            return redirect()->route('login')->with('message', 'Bạn không có quyền truy cập vào trang này!');

        }
        return $next($request);
    }
}
