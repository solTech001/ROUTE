<?php

declare(strict_types=1);

namespace Tamedevelopers\Route;

use Closure;
use Tamedevelopers\Request\Request;
use Tamedevelopers\Route\Traits\RouteTrait;
use Tamedevelopers\Route\Traits\RouteHelperTrait;

class Route
{
    use RouteTrait, RouteHelperTrait;

    /**
     * request
     *
     * @var array
     */
    static protected $request;    

    /**
     * routes
     *
     * @var array
     */
    static protected $routes = [];    
    
    /**
     * middlewares
     *
     * @var array
     */
    static protected $middlewares = [];

    /**
     * namedRoutes
     *
     * @var array
     */
    static public $namedRoutes = [];
    
    /**
     * Prefix
     *
     * @var array
     */
    static protected $prefix;
    
    /**
     * Current Route
     *
     * @var mixed
     */
    static protected $currentRoute;

    // routes
    static public function tests()
    {
        dump(
            // self::$routes,
            self::$middlewares,
            self::$namedRoutes,
            self::$prefix,
        );
    }

    /**
     * Return Instance of Request Class
     *
     * @return \Tamedevelopers\Request\Request
     */
    static public function request()
    {
        return self::$request;
    }

    /**
     * Initialize route
     *
     * @return $this
     */
    private static function instance()
    {
        if (!self::$currentRoute) {
            self::$currentRoute = new self();
            self::$request      = new Request();
        }

        return self::$currentRoute;
    }

    /**
     * Add a GET route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function get($url, $callback)
    {
        return self::addRoute('GET', $url, $callback);
    }

    /**
     * Add a POST route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function post($url, $callback)
    {
        return self::addRoute('POST', $url, $callback);
    }

    /**
     * Add a PUT route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function put($url, $callback)
    {
        return self::addRoute('PUT', $url, $callback);
    }

    /**
     * Add a PATCH route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function patch($url, $callback)
    {
        return self::addRoute('PATCH', $url, $callback);
    }

    /**
     * Add a DELETE route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    public static function delete($url, $callback)
    {
        return self::addRoute('DELETE', $url, $callback);
    }

    /**
     * Add an OPTIONS route.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function options($url, $callback)
    {
        return self::addRoute('OPTIONS', $url, $callback);
    }

    /**
     * Define a group of routes with a common prefix and optional middleware.
     *
     * @param string|array $middlewareOrPrefix
     * @param Closure|null $callback
     * @return $this
     */
    public static function group($middlewareOrPrefix, Closure $callback = null)
    {
        return self::addToGroup($middlewareOrPrefix, $callback);
    }

    /**
     * Register a route that responds to any method.
     *
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static public function any($url, $callback)
    {
        return self::addRoute('GET', $url, $callback)
                    ->addRoute('POST', $url, $callback)
                    ->addRoute('PUT', $url, $callback)
                    ->addRoute('PATCH', $url, $callback)
                    ->addRoute('DELETE', $url, $callback)
                    ->addRoute('OPTIONS', $url, $callback);
    }

}