<?php

declare(strict_types=1);

namespace Framework;

class Router
{ //create class router
    private array $routes = [];
    private array $middlewares = []; //create a middleware array
    private array $errorHandler;
    public function add(string $method, string $path, array $controller)
    {
        $path = $this->normalizePath($path); //sending the path entered by developer to normalized it

        $regexPath = preg_replace('#{[^/]+}#','([^/]+)',$path);

        $this->routes[] = [
            'path' => $path,
            'method' => strtoupper($method),
            'controller' => $controller ,//register the controller
            'middlewares'=> [],
            'regexPath' => $regexPath
        ]; //this will create a multi dimentional array for storing routes 
        //print_r($this->routes);
    }
    private function normalizePath(string $path): string
    {
        $path = trim($path, '/'); //remove the / character from beginnig and ending of string
        $path = "/{$path}/"; //Adding the / character from beginning and ending of a string
        $path = preg_replace('#[/]{2,}#', '/', $path); //return only one /
        return $path; //return the normalize path
    }
    public function dispatch(string $path, string $method, Container $container = null)
    { //router dispatch method
        $path = $this->normalizePath($path);
        $method = strtoupper($_POST['_METHOD'] ?? $method);
        // dd($method);
        //echo $path . $method;//return path and method like phpiggy.local/sdgsgf-> output ->  /sdgsgf/GET 
        foreach ($this->routes as $route) {
            if (
                !preg_match("#^{$route['regexPath']}$#", $path,$paramsValue) ||
                $route['method'] !== $method
            ) { //^ is check beginning of pattern match and $ is check ending of the value is match
                continue;
            }
            array_shift($paramsValue);

            preg_match_all('#{([^/]+)}#',$route['path'],$paramsKeys);

            $paramsKeys = $paramsKeys[1];

            $params = array_combine($paramsKeys,$paramsValue);
            //dd($paramsKeys);
            //echo 'Route Found'; //print message if path and method are match
            [$class, $function] = $route['controller'];

            // $controllerInstance = new $class; //create controller class instance with string
            $controllerInstance = $container ?
                $container->resolve($class) : //resolve method -> it provide dependency to the controller
                new $class;

            $action = fn () => $controllerInstance->{$function}($params);

            $allMiddleware = [...$route['middlewares'],...$this->middlewares];
            // foreach ($this->middlewares as $middleware) //looping through middleware
            foreach ($allMiddleware as $middleware) 
            {
                $middlewareInstance = $container ?
                    $container->resolve($middleware) : //dependency injection in middleware
                    new $middleware;
                $action = fn () => $middlewareInstance->process($action); //chain of middleware / chaining callback function
            }
            $action();
            return;
        }
        $this->dispatchNotFound($container);
    }
    public function addMiddleware(string $middleware)
    {
        $this->middlewares[] = $middleware; //add this parameter to the middleware array
    }
    public function addRouteMiddleware(string $middleware){
        $lastRouteKey = array_key_last($this->routes);
        $this->routes[$lastRouteKey]['middlewares'][]=$middleware;

    }
    public function setErrorHandler(array $controller){
        $this->errorHandler = $controller;
    }
    public function dispatchNotFound(Container $container){
        [$class,$function]=$this->errorHandler;
        $controllerInstance = $container ? $container->resolve($class) : new $class;
        $action = fn () => $controllerInstance->$function();
        foreach($this->middlewares as $middleware){
            $middlewareInstance = $container ? $container->resolve($middleware) : new $class;
            $action = fn () => $middlewareInstance->process($action);
        }
        $action();
    }
}
