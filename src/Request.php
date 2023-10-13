<?php

declare(strict_types=1);

namespace Tamedevelopers\Request;

class Request
{    
    /**
     * @var string The full URL of the request.
     */
    protected $url;

    /**
     * @var array The segments of the URL.
     */
    protected $segments = [];

    /**
     * Constructor: Initializes the Request object and parses the URL into segments.
     */
    public function __construct()
    {
        $this->url = $_SERVER['REQUEST_URI'];
        $this->parseUrl();
    }

    /**
     * Parse the URL and extract segments.
     */
    protected function parseUrl()
    {
        // Remove query parameters from the URL if present
        $urlWithoutQuery = strtok($this->url, '?');

        // Explode the URL into segments
        $this->segments = explode('/', trim($urlWithoutQuery, '/'));

        // Remove empty segments
        $this->segments = array_filter($this->segments);
    }

    /**
     * Get the full URL.
     *
     * @return string The full URL.
     */
    public function getUrl()
    {
        // clean and remove the request parh from url
        $url = str_replace($_SERVER['REQUEST_URI'], '', $this->url);

        dd(
            $_SERVER
        );
        return $url;
    }

    /**
     * Get all segments of the URL.
     *
     * @return array The segments of the URL.
     */
    public function getSegments()
    {
        return $this->segments;
    }

    /**
     * Get a specific segment by index.
     *
     * @param int $index The index of the segment.
     * @return string|null The segment at the given index, or null if not found.
     */
    public function getSegment($index)
    {
        return isset($this->segments[$index]) ? $this->segments[$index] : null;
    }

    /**
     * Get all input parameters ($_REQUEST).
     *
     * @return array All input parameters ($_REQUEST).
     */
    public function all()
    {
        return $_REQUEST;
    }

    /**
     * Get an input parameter by key, with a default value if not present.
     *
     * @param string $key The key of the input parameter.
     * @param mixed $default The default value if the key is not found.
     * @return mixed The value of the input parameter, or the default value if not found.
     */
    public function input($key, $default = null)
    {
        return isset($_REQUEST[$key]) ? $_REQUEST[$key] : $default;
    }

}
