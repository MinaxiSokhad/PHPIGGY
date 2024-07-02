<?php
declare(strict_types=1);
namespace Framework\Rules;
use Framework\Contracts\RuleInterface;

class PasswordRule implements RuleInterface{

    private array $passErr = [];

    public function validate(array $data, string $field, array $params): bool
    {
        $password = $data[$field];

        if (strlen($password) < 8) 
        {
            $this->passErr[] = "The password must be 8-10 characters long .";  
        } 
        if(!preg_match("#[0-9]+#",$password)) 
        {
            $this->passErr[] = "Your Password Must Contain At Least 1 Number!";
        }
        if(!preg_match("#[A-Z]+#",$password)) 
        {
            $this->passErr[] = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        if(!preg_match("#[a-z]+#",$password)) 
        {
            $this->passErr[] = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
        if (!preg_match("/\W/", $password)) {
            $this->passErr[] = "Password should contain at least one special character";
        }
        if (preg_match("/\s/", $password)) {
            $this->passErr[] = "Password should not contain any white space";
        }
        return empty($this->passErr);
    }
    public function getMessage(array $data, string $field, array $params): string{
        return implode(',',$this->passErr);
    }
}