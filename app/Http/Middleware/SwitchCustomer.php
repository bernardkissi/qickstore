<?php

namespace App\Http\Middleware;

use App\Http\Middleware\VerifyVisitorCustomer;
use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;

class SwitchCustomer
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
        try {
            return app(Authenticate::class)->handle($request, function ($request) use ($next) {
                return $next($request);
            });
        } catch (\Exception $exception) {
            if ($exception instanceof AuthenticationException) {
                return app(VerifyVisitorCustomer::class)->handle($request, function ($request) use ($next) {
                    return $next($request);
                });
            }
            throw $exception;
        }
    }
}
