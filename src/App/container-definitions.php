<?php

declare(strict_types=1);

use Framework\{TemplateEngine,Database,Container};
use App\Config\Paths;
use App\Services\{ValidatorService,UserService,TransactionService,ReceiptService,ProfileService};

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW), // create a factory function -> factory function means create class object inside the function
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn() => new Database($_ENV['DB_DRIVER'],[
    'hostname' => $_ENV['DB_HOST'],
    'port'=>$_ENV['DB_PORT'],
    'dbname'=>$_ENV['DB_NAME']
    ],$_ENV['DB_USER'],$_ENV['DB_PASS']),
     UserService::class => function(Container $container){//using factory function define container definition 
         $db = $container->get(Database::class);
         return new UserService($db);
        },
         TransactionService::class => function(Container $container){
            $db = $container->get(Database::class);
            return new TransactionService($db);//inject service into the container
         },
         ReceiptService::class => function(Container $container){
            $db = $container->get(Database::class);
            return new ReceiptService($db); //inject service into the container
         },
         ProfileService::class => function(Container $container){
            $db = $container->get(Database::class);
            return new ProfileService($db); //inject service into the container
         }
]; //generate external definitions file
