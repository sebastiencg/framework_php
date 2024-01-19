<?php

namespace App\Controller;

use Core\Attributes\Route;
use Core\Controller\Controller;
use Core\Http\Response;

class HomeController extends Controller
{
    #[Route(uri: "/", name: "app_home_index", methods: ["get"])]
    //ajouter les methods : Post, GET, Delete, Put
    public function index():Response
    {
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home"
        ]);
    }

    #[Route(uri: "/home/show", name: "app_home_show", methods: ["GET", "POST"])]
    public function show():Response
    {
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home/show"
        ]);
    }

}