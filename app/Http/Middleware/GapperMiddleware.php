<?php

namespace App\Http\Middleware;

use Closure;

class GapperMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!\App\Gini\Gapper\Client::getUserName() && !in_array($request->url(), [route('root'), route('login')])) {
            return redirect()->to(route('root'));
        }

        return $next($request);
    }
}
