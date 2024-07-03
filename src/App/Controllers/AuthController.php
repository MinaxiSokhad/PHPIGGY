<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Services\{ValidatorService,UserService};

class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService,
        private UserService $userService
    ) {
    }
    public function registerView()
    {
        echo $this->view->render("register.php"); //render the register.php file 
    }
    public function register()
    {
        //dd($_POST);
        $this->validatorService->validateRegister($_POST);
        $this->userService->isEmailTaken($_POST['email']);
        $this->userService->create($_POST);
        redirectTo('/');
    }
    public function loginView()
    {
        echo $this->view->render("login.php"); //render the register.php file 
    }
    public function login(){
        
    }
}
