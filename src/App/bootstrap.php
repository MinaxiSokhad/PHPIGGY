<?php

declare(strict_types=1);
require __DIR__ . "/../../vendor/autoload.php";

use Framework\App;
use App\Config\Paths;
use App\Controllers\{HomeController, AboutController};
use function App\Config\{registerRoutes, registerMiddleware}; //register the function 

//echo HomeController::class; class magic constant 
$app = new App(Paths::SOURCE . "App/container-definitions.php");

// $app->add('/');//register route for home page 
//$app->get('/',['App\Controllers\HomeController','home']) class magic constant
//$app->get('/', [HomeController::class, 'home'/*pass/register Home controller */]); //http get method
//$app->get('/about', [AboutController::class, 'about'/*pass/register About controller */]);

registerRoutes($app); //register routes
registerMiddleware($app); //register middleware
// $app->get('about/team') ;
// $app->get('/about/team');
// $app->get('/about/team/');//always return one /
//dd($app); use sugar function
return $app;
