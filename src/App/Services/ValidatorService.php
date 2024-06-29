<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRule};

class ValidatorService
{
    private Validator $validator;
    public function __construct()
    {
        $this->validator = new Validator(); //create new instance of validator class
        $this->validator->add('required', new RequiredRule()); //set the alias 'required' and create the rule instance
        $this->validator->add('email', new EmailRule()); //create the emailrule instance and register the email rule in validator service class
    }
    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'], //apply email rules in alias
            'age' => ['required', 'min:18'],
            'country' => ['required'],
            'socialMediaURL' => ['required'],
            'password' => ['required'],
            'confirmPassword' => ['required'],
            'tos' => ['required'],
        ]);
    }
}
