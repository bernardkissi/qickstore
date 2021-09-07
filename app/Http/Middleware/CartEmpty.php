<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Cart\Facade\Cart;
use Illuminate\Http\Request;

class CartEmpty
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
        if (Cart::isEmpty()) {
            return response(['message' => 'Your cart is empty'], 400);
        }

        return $next($request);
    }
}
