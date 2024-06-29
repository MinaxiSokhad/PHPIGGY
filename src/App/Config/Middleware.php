<?php

declare(strict_types=1);

namespace App\Config;

use Framework\App;
use App\Middleware\{
    TemplateDataMiddleware,
    ValidationExceptionMiddleware,
    SessionMiddleware,
    FlashMiddleware
};

function registerMiddleware(App $app)
{
    $app->addMiddleware(TemplateDataMiddleware::class); //add the templatedatamiddleware class in addmiddleware method 
    $app->addMiddleware(ValidationExceptionMiddleware::class); //add validation exception middleware
    $app->addMiddleware(FlashMiddleware::class); //add flash middleware
    $app->addMiddleware(SessionMiddleware::class); //add session middleware -> start the session // session middleware register last because its execute first

}
