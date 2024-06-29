<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW) // create a factory function -> factory function means create class object inside the function
]; //generate external definitions file
