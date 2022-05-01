<?php

namespace app\core;

class Router
{

    public Request $request;
    public Response $response;
    protected array $routes = [];
    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    // runs when get request has been made
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    // runs when post request has been made
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path =  $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
           $this->response->setStatusCode(404);
           return $this->renderView("_404");
        }

        if (is_string($callback)){
            return $this->renderView($callback);
        }

        echo call_user_func($callback);
    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        // search for content placeholder in main.php  and relpace
        return str_replace('{{content}}', $viewContent, $layoutContent);   
    }

    public function layoutContent()
    {
        // cache string
        ob_start();
        include_once Application::$ROOT_DIR .  "/views/layouts/main.php";
        // output return and clear buffer
        return ob_get_clean();

    }

    protected function renderOnlyView($view)
    {
           // cache string
           ob_start();
           include_once Application::$ROOT_DIR .  "/views/$view.php";
           // output return and clear buffer
           return ob_get_clean();
    }
}
