<?php 
namespace app\controllers;

use app\core\Application;
use app\core\Router;

class Controller
{
    public Router $router; 
    public string $layout = 'main';

    public function __construct()
    {
        $this->router = Application::$app->router;
    }

    public function render($view, $params=[])
    {
        return $this->router->renderView($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

}