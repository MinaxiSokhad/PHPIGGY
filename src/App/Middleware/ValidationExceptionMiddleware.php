<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $e) {
            $oldFormData = $_POST;
            $excludedFields = ['password','confirmPassword'];
            $formattedFormData = array_diff_key($oldFormData,array_flip($excludedFields));

            // dd($e->errors); //show the error 
            
            $_SESSION['errors'] = $e->errors; //session are accessible via super global variable $_SESSION
            
            
            $_SESSION['oldFormData']=$formattedFormData;//use for store old form data in
            // dd($oldFormData);
            $refere = $_SERVER['HTTP_REFERER']; //it store the url where the form was submitted therefore will always redirected to the same url with the original form
            
            // redirectTo("/register"); //if data is empty redirect to register page 
            redirectTo("{$refere}");

            // dd($e->errors); //show the error 
            $_SESSION['errors'] = $e->errors; //session are accessible via super global variable $_SESSION
            $refere = $_SERVER['HTTP_REFERER']; //it store the url where the form was submitted therefore will always redirected to the same url with the original form
            // redirectTo("/register"); //if data is empty redirect to register page 
            redirectTo($refere);

        }
    }
}
