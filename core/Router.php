<?php
namespace app\core;

class Router
{
    public array $routes = [];
    public Request $request; 
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request; 
        $this->response = $response;
    }
    
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method(); 
        $callback = $this->routes[$method][$path] ?? false; 
        
        if($callback === false){
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
        }
        if(is_array($callback)){
           Application::$app->controller = new $callback[0](); 
           $callback[0] = Application::$app->controller;
        }
        return call_user_func($callback, $this->request);
    }

    public function renderView($view,$params=[])
    {  
        $layout = $this->renderLayout();
        $viewContents = $this->renderViewContents($view,$params); //#
        return str_replace('{{contents}}', $viewContents, $layout);
    }

    public function renderLayout(){
        $layout = Application::$app->controller->layout; 
        ob_start();
        include Application::$ROOT_DIR."/views/layouts/{$layout}.php";
        return ob_get_clean();
    }
    public function renderViewContents($view, $params=[]) // $params=[]    
    { 
        $test = '인클루드가 일어나는 경우 함수 내에서 선언된 변수를 뷰페이지에서 사용할 수 있다.';
        foreach ($params as $key => $value) {
            $$key = $value; 
        }
        ob_start();
        include Application::$ROOT_DIR."/views/{$view}.php";
        return ob_get_clean();
    }
}