<?php

namespace App\Http\Middleware;

use App\Models\Society;
use Closure;
use Illuminate\Http\Request;

class TokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Society::where('login_tokens', $request->token)->first();
        if (!$request->token || !$user) {
            return response()->josn([
                'message' => 'Unautorized user',
            ], 401);
        }
        return $next($request);
    }
}
