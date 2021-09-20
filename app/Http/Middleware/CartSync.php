<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Cart\Facade\Cart;
use Illuminate\Http\Request;

class CartSync
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Cart::sync();

        if (Cart::hasChanged()) {
            return response()->json(
                ['message' => 'Item quantity in cart has reduced, due to a place order'],
                409
            );
        }
        return $next($request);
    }
}
