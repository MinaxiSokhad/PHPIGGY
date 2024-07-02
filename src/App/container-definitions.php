<?php

declare(strict_types=1);

use Framework\TemplateEngine;
use App\Config\Paths;
use App\Services\ValidatorService;

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW), // create a factory function -> factory function means create class object inside the function
    ValidatorService::class => fn () => new ValidatorService()
]; //generate external definitions file
