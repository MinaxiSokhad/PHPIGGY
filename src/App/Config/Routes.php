<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Controllers\{
    HomeController,
    AboutController,
    AuthController,
    TransactionController,
    ReceiptController,
    ErrorController,
    ProfileController
};
use App\Middleware\{AuthRequiredMiddleware,GuestOnlyMiddleware};

function registerRoutes(App $app) //register the route and then autoload files
{
    //store the routes
    $app->get('/', [HomeController::class, 'home'/*pass/register Home controller */])->add(AuthRequiredMiddleware::class); //http get method
    $app->get('/about', [AboutController::class, 'about'/*pass/register About controller */]);
    $app->get('/register', [AuthController::class, 'registerView'])->add(GuestOnlyMiddleware::class); // routes the register authenticate controller and this method -> in registerview method render the register.php file
    $app->post('/register', [AuthController::class, 'register'])->add(GuestOnlyMiddleware::class); //register post method for receive the register data
    $app->get('/login', [AuthController::class, 'loginView'])->add(GuestOnlyMiddleware::class);
    $app->post('/login', [AuthController::class, 'login'])->add(GuestOnlyMiddleware::class);
    $app->get('/logout',[AuthController::class,'logout'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction',[TransactionController::class,'createView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction',[TransactionController::class,'create'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}',[TransactionController::class,'editView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/{transaction}',[TransactionController::class,'edit'])->add(AuthRequiredMiddleware::class);
    $app->delete('/transaction/{transaction}',[TransactionController::class,'delete'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}/receipt',[ReceiptController::class,'uploadView'])->add(AuthRequiredMiddleware::class);
    $app->post('/transaction/{transaction}/receipt',[ReceiptController::class,'upload'])->add(AuthRequiredMiddleware::class);
    $app->get('/transaction/{transaction}/receipt/{receipt}',[ReceiptController::class,'download'])->add(AuthRequiredMiddleware::class);
    $app->delete('/transaction/{transaction}/receipt/{receipt}',[ReceiptController::class,'delete'])->add(AuthRequiredMiddleware::class);

    $app->setErrorHandler([ErrorController::class,'notfound']);

    $app->get('/profile/{user}',[ProfileController::class,'profileView'])->add(AuthRequiredMiddleware::class);
    $app->post('/profile/{user}',[ProfileController::class,'updateProfile'])->add(AuthRequiredMiddleware::class);
}


