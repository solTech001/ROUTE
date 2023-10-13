<?php

declare(strict_types=1);

namespace Tamedevelopers\Providers;

use Closure;


class ServiceProvider
{
    /**
     * The controller namespace for the application.
     *
     * @var string|null
     */
    protected $namespace;

    /**
     * The callback that should be used to load the application's routes.
     *
     * @var \Closure|null
     */
    protected $loadRoutesUsing;

    /**
     * Register any application services.
     *
     * This method is called when registering application services.
     *
     * @return void
     */
    public function register()
    {
        $this->booted(function () {
            $this->setRootControllerNamespace();
            $this->loadRoutes();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * This method is called when bootstrapping application services.
     *
     * @return void
     */
    public function boot()
    {
        // Implement boot logic if needed
    }

    /**
     * Register the callback that will be used to load the application's routes.
     *
     * @param  \Closure  $routesCallback  The callback to load routes
     * @return $this
     */
    protected function routes(Closure $routesCallback)
    {
        $this->loadRoutesUsing = $routesCallback;
        return $this;
    }

    /**
     * Set the root controller namespace for the application.
     *
     * Implement this method to set the root controller namespace if needed.
     *
     * @return void
     */
    protected function setRootControllerNamespace()
    {
        // Implement setting the root controller namespace if needed
    }

    /**
     * Load the application routes.
     *
     * If a routes callback is provided, it will be invoked to load routes.
     *
     * @return void
     */
    protected function loadRoutes()
    {
        if (!is_null($this->loadRoutesUsing)) {
            // Call the routes callback
            $this->loadRoutesUsing->__invoke();
        }
    }

    /**
     * Pass dynamic methods onto the router instance.
     *
     * This magic method allows handling dynamic method calls.
     *
     * @param  string  $method     Method name to call
     * @param  array   $parameters Parameters for the method
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        // Implement handling dynamic methods if needed
    }
}
