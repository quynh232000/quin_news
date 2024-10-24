<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class IsLoginMiddleware
{
   
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return $next($request);
        } else {
            $currentUrl = url()->current();
            // dd($currentUrl);
            Session::put('redirect_url', $currentUrl);
            return redirect()->route('login')->with('message', 'Vui lòng đăng nhập !');

        }

    }
}
