<?php

namespace App\Controller;

use Core\Attributes\Route;
use Core\Controller\Controller;
use Core\Http\Response;

class UserController extends Controller
{
    #[Route(uri: "/user/make", name: "app_user_create", methods: ["POST"])]
    public function make():Response
    {
        return $this->render("user/index", [
            "pageTitle"=> "Welcome to /user/make"
        ]);
    }

    #[Route(uri: "/user/delete", name: "app_user_delete", methods: ["DELETE"])]
    public function delete():Response
    {
        return $this->render("user/index", [
            "pageTitle"=> "Welcome to /user/delete"
        ]);
    }

}