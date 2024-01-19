<?php

namespace Core\Controller;

use Core\Attributes\Route;
use Core\Http\Response;

abstract class Controller
{
    private Response $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function redirect(string $route = null)
    {

        return $this->response->redirect($route);
    }
    public function render($nomDeTemplate, $donnees)
    {
        return $this->response->render($nomDeTemplate, $donnees);
    }
}