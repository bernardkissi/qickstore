<?php

namespace App\Http\Middleware;

use App\Domains\User\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class VerifyVisitorCustomer
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
        $cookie = $request->cookie('identifier') ?? '';
        $cacheVisitor = $this->hasCacheVisitor($cookie) ? $this->cacheVisitor($cookie) : false;

        if ($cacheVisitor) {
            $this->setVisitor($request, $cacheVisitor);
        }

        $this->verifyVisitor($request);

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
        $request->merge(['visitor' => $guest]);
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

    /**
     * Cache the visitor
     *
     * @param string $cookie
     * @param integer $seconds
     * @return void
     */
    public function setCacheVisitor(string $cookie, Visitor $visitor, int $seconds = 3600): void
    {
        Cache::add($cookie, $visitor, $seconds);
    }

    /**
     * Return cache visitor
     *
     * @param string $cookie
     * @return Visitor
     */
    public function cacheVisitor(string $cookie): Visitor
    {
        return Cache::get($cookie);
    }

    /**
     * Checks if visitor is in cache
     *
     * @param string $cookie
     * @return boolean
     */
    public function hasCacheVisitor(string $cookie): bool
    {
        return Cache::get($cookie) ? true : false;
    }

    /**
     * Verify current visitor
     *
     * @param Request $request
     * @return void
     */
    public function verifyVisitor(Request $request): void
    {
        $key = Str::uuid();
     
        $cookie = $request->hasCookie('identifier') ? $request->cookie('identifier') : $this->setCookie($key);
        if (is_null($cookie)) {
            $cookie = $_COOKIE["identifier"] = $key;
        }

        $guest = $this->hasVisitor($cookie) ? $this->getVisitor($cookie): $this->createVisitor($cookie);
        
        $this->setVisitor($request, $guest);
        $this->setCacheVisitor($cookie, $guest);
    }
}
