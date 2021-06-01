<?php

namespace App\Http\Middleware;

use App\Domains\User\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VerifyGuestCustomer
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
        //check if cookie exist
        $cookie = $request->hasCookie('identifier') ? $request->cookie('identifier') : $this->setCookie();
        if (is_null($cookie)) {
            $cookie = $request->cookie('identifier');
        }
        //Check if a guest exist
        $guest = $this->hasVisitor($cookie) !== false ? $this->getVisitor($cookie): $this->createVisitor($cookie);
        // finally merge guest into request
        $this->setVisitor($request, $guest);

        return $next($request);
    }

 
    /**
    * Set Cookies on guest machine
    *
    * @return void
    */
    public function setCookie(): void
    {
        $cookie = Str::uuid();
        setcookie('name', $cookie, time()+3600);
    }

    /**
    * Undocumented function
    *
    * @param Request $request
    * @param Guest $guest
    * @return void
    */
    public function setVisitor(Request $request, Visitor $guest): void
    {
        $request->merge(['guest' => $guest]);
    }

    /**
    * Checks if guest already exist
    *
    * @param string $cookie
    * @return boolean
    */
    public function hasVisitor(string $cookie): bool
    {
        $guest = Visitor::where('identifier', $cookie)->first();
        return $guest ? true : false;
    }
    
    /**
    * Returns an exisiting visitor
    *
    * @param string $cookie
    * @return Visitor
    */
    public function getVisitor(string $cookie): Visitor
    {
        return Visitor::where('identifier', $cookie)->first();
    }

    /**
    * Create a guest user
    *
    * @param string $cookie
    * @return Visitor
    */
    public function createVisitor(string $cookie): Visitor
    {
        return Visitor::create(['identifier' => $cookie]);
    }
}
