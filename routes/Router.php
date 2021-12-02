<?php

namespace Router;

class Router
{
    public string $url;
    public array $routes;
    
    public function __construct($url)
    {
        $this->url = trim($url, '/');
    }

    /**
     * Retrieve the path and action to create a new route
     *
     * @param string $path
     * @param string $action
     * @return void
     */
    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
    }

    /**
     * Check if route
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
        }
        return header('HTTP/1.0 404 Not Found');
    }
}