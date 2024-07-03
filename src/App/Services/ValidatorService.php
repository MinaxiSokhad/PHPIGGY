<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Validator;
use Framework\Rules\{RequiredRule, EmailRule,MinRule,InRule,UrlRule,MatchRule,PasswordRule,AgeRule};

class ValidatorService
{
    private Validator $validator;
    public function __construct()
    {
        $this->validator = new Validator(); //create new instance of validator class
        $this->validator->add('required', new RequiredRule()); //set the alias 'required' and create the rule instance
        $this->validator->add('email', new EmailRule()); //create the emailrule instance and register the email rule in validator service class
        $this->validator->add('minmax', new MinRule()); //create minrule instance for age field validation
        $this->validator->add('agerule', new AgeRule());
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());
        $this->validator->add('pass', new PasswordRule());
    }
    public function validateRegister(array $formData)
    {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'], //apply email rules in alias
            'age' => ['required', 'minmax:18','agerule'],
            'country' => ['required','in:USA,Canada,Mexico'],
            'socialMediaURL' => ['required','url'],
            'password' => ['required','pass'],
            'confirmPassword' => ['required','match:password'],
            'tos' => ['required'],
        ]);
    }
    public function validateLogin(array $formData){
        $this->validator->validate($formData, [
            'email' => ['required', 'email'], 
            'password' => ['required','pass'],
        ]);
    }
}
