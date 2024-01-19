<?php

namespace Core\Kernel;

use Core\Environment\DotEnv;
use Core\Http\Request;
use Core\Http\Response;
use Core\Router\Router;

class Kernel
{

    public static function run() : Response
    {
        $dotEnv = new DotEnv();
        $environment = $dotEnv->getVariable("ENVIRONMENT");

        if($environment === "dev"){
            \Core\Debugging\Debugger::run();
        }

        $request = new Request;
        $router = new Router();

        $controllerAndMethod = $router->getControllerAndMethod($request);

        //echo '<pre>';
        //    print_r($controllerAndMethod);
        //echo '</pre>';
        $controllerName = $controllerAndMethod->getController();

        $controller = new $controllerName();

        $method = $controllerAndMethod->getMethod();

        return $controller->$method();
        // vérifier si c'est GET ou POST, ...

    }

}