<?php

declare(strict_types=1);

namespace Tamedevelopers\Route;

class Middleware
{    
    
    /**
     * handle
     *
     * @param  mixed $request
     * @param  mixed $next
     * @return void
     */
    public static function handle($request, $next)
    {
        // Perform middleware operations here
        // You can access the request and modify it if needed
        // Call the $next() function to proceed to the next middleware or route

        $next();
    }


}
