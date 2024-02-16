<?php

namespace App\Controller;

use Core\Attributes\Route;
use Core\Controller\Controller;
use Core\Http\Response;
use Core\HttpClient\HttpClient;

class HomeController extends Controller
{

    #[Route(uri: "/", name: "app_home_index", methods: ["GET"])]
    public function index():Response
    {
        $client = new HttpClient('https://quizz.esdlyon.dev');
        $response = $client->get('/party/start/last');
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home",
            "data"=>$response
        ]);


    }

    #[Route(uri: "/home/show/{id}", name: "app_home_show", methods: ["GET", "POST"])]
    public function show(int $id):Response
    {
        //echo($id);
        return $this->render("home/index", [
            "pageTitle"=> "Welcome to /home/show"
        ]);
    }

}