<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
    HomeController,
    AboutController,
    AuthController
};

function registerRoutes(App $app) //register the route and then autoload files
{
    //store the routes
    $app->get('/', [HomeController::class, 'home'/*pass/register Home controller */]); //http get method
    $app->get('/about', [AboutController::class, 'about'/*pass/register About controller */]);
    $app->get('/register', [AuthController::class, 'registerView']); // routes the register authenticate controller and this method -> in registerview method render the register.php file
}
