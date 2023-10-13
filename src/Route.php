<?php

declare(strict_types=1);

namespace Tamedevelopers\Route;

use Tamedevelopers\Route\Traits\RouteTrait;

class Route
{
    
    use RouteTrait;

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
    static protected $namedRoutes = [];
    
    /**
     * Prefix
     *
     * @var array
     */
    static protected $prefix;
    
    /**
     * Route Base directory
     *
     * @var array
     */
    static protected $routeBaseDirectory;

    


    // routes


    /**
     * Add a GET route.
     *
     * @param string $uri
     * @param callable|string|array $callback
     * @return void
     */
    public static function get($uri, $callback)
    {
        self::addRoute('GET', $uri, $callback);
    }

    /**
     * Add a POST route.
     *
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function post($uri, $callback)
    {
        self::addRoute('POST', $uri, $callback);
    }

    /**
     * Add a PUT route.
     *
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function put($uri, $callback)
    {
        self::addRoute('PUT', $uri, $callback);
    }

    /**
     * Add a PATCH route.
     *
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function patch($uri, $callback)
    {
        self::addRoute('PATCH', $uri, $callback);
    }

    /**
     * Add an OPTIONS route.
     *
     * @param string $uri
     * @param mixed $callback
     * @return void
     */
    public static function options($uri, $callback)
    {
        self::addRoute('OPTIONS', $uri, $callback);
    }

}