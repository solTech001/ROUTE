<?php

declare(strict_types=1);

namespace Tamedevelopers\Route\Traits;

use Exception;


/**
 * @property mixed $routes
 * @property mixed $middlewares
 * @property mixed $namedRoutes
 * @property mixed $prefix
 * 
 * @see \Tamedevelopers\Route\Route
 */
trait RouteTrait{


    /**
     * Add a route with specified method, URI, and callback.
     *
     * @param string $method
     * @param string $uri
     * @param callable|string|array $callback
     * @return void
     */
    protected static function addRoute($method, $uri, $callback)
    {
        $route = [
            'method' => $method,
            'uri' => $uri,
            'callback' => $callback,
            'middlewares' => self::$middlewares,
        ];

        self::$routes[] = $route;
    }

    /**
     * Set the name of the current route.
     *
     * @param string $name
     * @return void
     * @throws Exception
     */
    public static function name($name)
    {
        if (isset(self::$namedRoutes[$name])) {
            throw new Exception("Route name '$name' already exists. Please choose a different name.");
        }

        $currentRoute = end(self::$routes);
        self::$namedRoutes[$name] = $currentRoute;
    }

    /**
     * Add middleware to be applied to subsequent routes.
     *
     * @param string|array $middlewares
     * @return void
     */
    public static function middleware($middlewares)
    {
        if (is_array($middlewares)) {
            self::$middlewares = array_merge(self::$middlewares, $middlewares);
        } else {
            self::$middlewares[] = $middlewares;
        }
    }

    /**
     * Group routes under a common prefix.
     *
     * @param string $prefix
     * @param callable $callback
     * @return void
     */
    public static function prefix($prefix, $callback)
    {
        $previousPrefix = self::$prefix;

        self::$prefix .= $prefix;

        $callback();

        self::$prefix = $previousPrefix;
    }

    /**
     * Register a route that matches multiple methods.
     *
     * @param array|string $methods
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function match($methods, $uri, $callback)
    {
        if (is_string($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            self::addRoute(strtoupper($method), $uri, $callback);
        }
    }

    /**
     * Register a route that responds to any method.
     *
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function any($uri, $callback)
    {
        self::addRoute('GET', $uri, $callback);
        self::addRoute('POST', $uri, $callback);
        self::addRoute('PUT', $uri, $callback);
        self::addRoute('PATCH', $uri, $callback);
        self::addRoute('DELETE', $uri, $callback);
        self::addRoute('OPTIONS', $uri, $callback);
    }

    /**
     * Redirect a route to another URI.
     *
     * @param string $from
     * @param string $to
     * @param int $status
     * @return void
     */
    public static function redirect($from, $to, $status = 302)
    {
        self::addRoute('GET', $from, function () use ($to, $status) {
            header("Location: {$to}", true, $status);
            exit;
        });
    }

    /**
     * Permanently redirect a route to another URI.
     *
     * @param string $from
     * @param string $to
     * @param int $status
     * @return void
     */
    public static function permanentRedirect($from, $to, $status = 301)
    {
        self::redirect($from, $to, $status);
    }

}