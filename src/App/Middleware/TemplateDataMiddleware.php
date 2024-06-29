<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface //create a middleware
{
    public function __construct(private TemplateEngine $view)
    {
        // var_dump($this->view);
        // echo '<br>';
    }
    public function process(callable $next)
    {
        //echo "Template Data Middleware";
        $this->view->addGlobal('title', "Expence tracking app"); //add the global template variables -> only the middleware code will run
        $next(); // this step is important -> if we don't call the next function , the controller never gets handed the request 
    }
}
