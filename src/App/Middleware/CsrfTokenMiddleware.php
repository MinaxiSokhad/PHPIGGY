<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class CsrfTokenMiddleware implements MiddlewareInterface
{
  public function __construct(private TemplateEngine $view)
  {
  }

  public function process(callable $next)
  {
    $_SESSION['token'] = $_SESSION['token'] ?? bin2hex(random_bytes(32)); //create csrf token 
    $this->view->addGlobal('csrfToken',$_SESSION['token']); //add in template engine global method store key and value
    $next();
  }
}