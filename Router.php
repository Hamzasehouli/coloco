<?php

namespace coloco;

class Router
{
    private $getRoutes;
    private $postRoutes;

    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }
    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function call()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = $_SERVER['PATH_INFO'] ?? '/';
        $fn = null;

        if ($method === 'GET') {
            $fn = $this->getRoutes[$path];
        } else {
            $fn = $this->postRoutes[$path];
        }
        if ($fn) {
            call_user_func($fn);
        } else {
            echo "No route found with:$path";
        }
    }
}