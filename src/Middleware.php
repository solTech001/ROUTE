<?php

declare(strict_types=1);

namespace Tamedevelopers\Middleware;

use Closure;
use Tamedevelopers\Request\Request;

class Middleware
{    

    /**
     * Handle incoming request
     *
     * @param  \Tamedevelopers\Request\Request $request
     * @param  Closure $next
     * @return void
     */
    public static function handle(Request $request, Closure $next)
    {
        // Perform middleware operations here
        // You can access the request and modify it if needed
        // Call the $next() function to proceed to the next middleware or route

        $next($request);
    }
}
