<?php

use Tamedevelopers\Route\View;

// The `AppIsNotCorePHP()` returns boolean as true|false
// We always want out package to work on frameworks as well.
// 

// at the end of the day we can define all of our php function helpers inside this file alone




if (! AppIsNotCorePHP() && ! function_exists('view')) {
    /**
     * Create a new View instance.
     *
     * @param string $viewPath The path to the view file.
     * @param array $data The data to be passed to the view.
     * class
     * @return mixed
     */
    function view($viewPath, $data = [])
    {
        return new View($viewPath, $data);
    }
}

