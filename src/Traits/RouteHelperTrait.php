<?php

declare(strict_types=1);

namespace Tamedevelopers\Route\Traits;

use Exception;
use Tamedevelopers\Support\Capsule\Manager;


/**
 * @property mixed $routes
 * @property mixed $middlewares
 * @property mixed $namedRoutes
 * @property mixed $prefix
 * 
 * @see \Tamedevelopers\Route\Route
 */
trait RouteHelperTrait
{
    /**
     * Get the URL of a named route.
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    static protected function route($name, $params = [])
    {
        if (isset(self::$namedRoutes[$name])) {
            $route = self::$namedRoutes[$name];
            $url = $route['url'];

            foreach ($params as $key => $value) {
                $url = str_replace('{' . $key . '}', $value, $url);
            }

            return $url;
        }

        return '';
    }

    /**
     * Cache the routes in a PHP file.
     *
     * @param string $cacheFile
     * @return void
     */
    static protected function cacheRoutes($cacheFile)
    {
        $routeCache = var_export(self::$routes, true);
        $content = "<?php\n\nreturn $routeCache;\n";
        file_put_contents($cacheFile, $content);
    }

    /**
     * Load routes from a cache file.
     *
     * @param string $cacheFile
     * @return void
     */
    static protected function loadRoutesFromCache($cacheFile)
    {
        if (file_exists($cacheFile)) {
            self::$routes = include $cacheFile;
        }
    }

    /**
     * Retrieve all registered routes.
     *
     * @return array
     */
    static protected function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Retrieve all registered middlewares.
     *
     * @return array
     */
    static protected function getMiddlewares()
    {
        return self::$middlewares;
    }

    /**
     * Retrieve all registered route names.
     *
     * @return array
     */
    static protected function getNamedRoutes()
    {
        return self::$namedRoutes;
    }

    /**
     * Run a middleware.
     *
     * @param string $middleware
     * @return void
     */
    static protected function runMiddleware($middleware)
    {
        if (isset(self::$middlewares[$middleware])) {
            $middlewareClass = self::$middlewares[$middleware];
            $middlewareInstance = new $middlewareClass();
            $middlewareInstance->handle();
        }
    }

    /**
     * Match a route URL against the current request URL.
     *
     * @param string $routeUrl
     * @param string $requestUrl
     * @return bool
     */
    static protected function matchRoute($routeUrl, $requestUrl)
    {
        // Escape special characters in the route URL
        $routeUrl = preg_quote($routeUrl, '#');

        // Handle optional route parameters
        $routeUrl = preg_replace('#\\\{(.+?)\\\?\\\}#', '([^/]+)?', $routeUrl);

        // Replace route parameters with regex patterns
        $routeUrl = preg_replace('#\\\{(.+?)\\\}#', '([^/]+)', $routeUrl);

        // Add start and end delimiters and case insensitivity
        $regex = '#^' . $routeUrl . '$#i';

        // Perform the match
        return preg_match($regex, $requestUrl);
    }

    /**
     * Execute Header With Status Code
     *
     * @param  int $status
     * @return void
     */
    static protected function execHeaderWithStatusCode($status = 404)
    {
        Manager::setHeaders($status);
    }
    
    

    

}
