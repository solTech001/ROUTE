<?php

declare(strict_types=1);

namespace Tamedevelopers\Route\Traits;

use Closure;
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
     * Define a group of routes with a common prefix and optional middleware.
     *
     * @param string|array $middlewareOrPrefix
     * @param Closure|null $callback
     * 
     * @return $this
     */
    public static function addToGroup($middlewareOrPrefix, Closure $callback = null)
    {
        // Set the prefix and middleware based on the argument type
        $prefix = null;
        $middlewares = [];

        if (is_array($middlewareOrPrefix)) {
            if (isset($middlewareOrPrefix['prefix'])) {
                $prefix = $middlewareOrPrefix['prefix'];
            }

            if (isset($middlewareOrPrefix['middleware'])) {
                $middlewares = is_array($middlewareOrPrefix['middleware']) ?
                    $middlewareOrPrefix['middleware'] :
                    [$middlewareOrPrefix['middleware']];
            }
        } elseif (is_string($middlewareOrPrefix)) {
            $prefix = $middlewareOrPrefix;
        }

        // Store the current prefix and middlewares
        $previousPrefix = self::$prefix;
        $previousMiddlewares = self::$middlewares;

        // Set the new prefix and middlewares for this group
        if (!is_null($prefix)) {
            self::$prefix .= '/' . trim($prefix, '/');
        }

        self::$middlewares = array_merge(self::$middlewares, $middlewares);
        // self::$prefix = array_merge(self::$prefix, $prefix);

        // dd(
        //     $prefix,
        //     $middlewares,
        //     $middlewareOrPrefix,
        //     self::$prefix
        // );

        // Call the callback to define routes within the group
        $callback();

        // Restore the previous prefix and middlewares after defining group routes
        self::$prefix = $previousPrefix;
        self::$middlewares = $previousMiddlewares;

        return self::instance();
    }

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
