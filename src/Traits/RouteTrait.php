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
trait RouteTrait{

    /**
     * Add a route with specified method, URI, and callback.
     *
     * @param string $method
     * @param string $url
     * @param mixed $callback
     * @return $this
     */
    static protected function addRoute($method, $url, $callback)
    {
        $route = [
            'method' => $method,
            'url' => $url,
            'callback' => $callback,
            'middlewares' => self::$middlewares,
        ];

        self::$routes[] = $route;

        return self::instance();
    }

    /**
     * Set the name of the current route.
     *
     * @param string $name
     * @return $this
     * @throws Exception
     */
    static public function name($name)
    {
        if (isset(self::$namedRoutes[$name])) {
            throw new Exception( sprintf("Route name '%s' already exists. Please choose a different name.", $name) );
        }

        $currentRoute = end(self::$routes);
        self::$namedRoutes[$name] = $currentRoute;

        return self::instance();
    }

    /**
     * Add middleware to be applied to subsequent routes.
     *
     * @param string|array $middlewares
     * @return $this
     */
    static public function middleware($middlewares)
    {
        if (is_array($middlewares)) {
            self::$middlewares = array_merge(self::$middlewares, $middlewares);
        } else {
            self::$middlewares[] = $middlewares;
        }

        return self::instance();
    }

    /**
     * Dispatch the current request.
     *
     * @param string $method
     * @param string $url
     * @return void
     */
    static public function dispatch($method, $url)
    {
        foreach (self::$routes as $route) {

            // dd( 
            //     $route,
            //     self::matchRoute($route['url'], $url),
            //     $route['method'] === $method
            // );

            dump(
                // $method, 
                $url
            );


            if ($route['method'] === $method && self::matchRoute($route['url'], $url)) {
                // Run middlewares
                foreach ($route['middlewares'] as $middleware) {
                    self::runMiddleware($middleware);
                }

                // Run the route action
                if (is_callable($route['action'])) {
                    $route['action']();
                } elseif (is_array($route['action']) && count($route['action']) === 2) {
                    $controller = $route['action'][0];
                    $method = $route['action'][1];
                    $controllerInstance = new $controller();
                    $controllerInstance->$method();
                }

                return;
            }
        }

        // Handle route not found
        // self::execHeaderWithStatusCode(404);
        echo "404 - Route not found!";
    }

    /**
     * Group routes under a common prefix.
     *
     * @param string $prefix
     * @param Closure $callback
     * @return void
     */
    static public function prefix($prefix, Closure $callback)
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
     * @param string $url
     * @param mixed $callback
     * @return void
     */
    static public function match($methods, $url, $callback)
    {
        if (is_string($methods)) {
            $methods = [$methods];
        }

        foreach ($methods as $method) {
            self::addRoute(strtoupper($method), $url, $callback);
        }
    }

    /**
     * Redirect a route to another URI.
     *
     * @param string $from
     * @param string $to
     * @param int $status
     * @return void
     */
    static public function redirect($from, $to, $status = 302)
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
    static public function permanentRedirect($from, $to, $status = 301)
    {
        self::redirect($from, $to, $status);
    }

    /**
     * Generate the URL for a named route.
     *
     * @param string $name
     * @param mixed ...$params
     * @return string
     * @throws Exception
     */
    static public function generateUrl($name, ...$params)
    {
        if (isset(self::$namedRoutes[$name])) {
            $route = self::$namedRoutes[$name];
            $url = $route['url'];

            // Check if the route has any parameters
            preg_match_all('/\{([^{}]+)\??\}/', $url, $matches);

            $routeParams = $matches[1];

            // Validate the number of parameters passed
            if (count($params) !== count($routeParams)) {
                throw new Exception("Invalid number of parameters passed for route '{$name}'.");
            }

            // Map params based on the route URL structure
            foreach ($params as $key => $param) {
                $url = str_replace("{{$routeParams[$key]}}", $param, $url);
            }

            return $url;
        }

        return '';
    }

}