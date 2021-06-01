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
        $key = Str::uuid();
     
        $cookie = $request->hasCookie('identifier') ? $request->cookie('identifier') : $this->setCookie($key);
        if (is_null($cookie)) {
            $cookie = $_COOKIE["identifier"] = $key;
        }

        $guest = $this->hasVisitor($cookie) ? $this->getVisitor($cookie): $this->createVisitor($cookie);
        
        $this->setVisitor($request, $guest);

        return $next($request);
    }

 
    /**
    * Set Cookies on guest machine
    *
    * @return void
    */
    public function setCookie(string $key): void
    {
        setcookie('identifier', $key, [
            'expires' => time()+3600,
            'httponly' => true,
            'secure' => false
        ]);
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
    public function hasVisitor(?string $cookie): bool
    {
        $guest = Visitor::where('identifier', $cookie)?->first();
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
        Visitor::create(['identifier' => $cookie]);
        return $this->getVisitor($cookie);
    }

    public function verifyVisitor()
    {
    }
}
