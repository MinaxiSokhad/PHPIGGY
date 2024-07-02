<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class FlashMiddleware implements MiddlewareInterface
{
    public function __construct(private TemplateEngine $view)
    {
    }
    public function process(callable $next)
    {
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []); //nullish operator for check an empty value
        unset($_SESSION['errors']); //unset function is used to destroy the specific items or variables in array 


        $this->view->addGlobal('oldFormData', $_SESSION['oldFormData'] ?? []); //nullish operator for check an empty value
        unset($_SESSION['oldFormData']);


        $next(); //flashing is a concept of programming where data is deleted after a single request
    }
}
