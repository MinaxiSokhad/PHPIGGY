<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RuleInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];
    public function add(string $alias, RuleInterface $rule)
    {
        $this->rules[$alias] = $rule; //add rules for registration form
    }
    public function validate(array $formData, array $fields)
    {
        $errors = [];
        // dd($formData);
        foreach ($fields as $fieldName => $rules) {
            foreach ($rules as $rule) {
                $ruleParams = [];
                if (str_contains($rule, ':')) {
                    [$rule, $ruleParams] = explode(':', $rule); //it convert string into array
                     // min,18
                    $ruleParams = explode(',', $ruleParams);
                     //18 in rule params as array
                }
                $ruleValidator = $this->rules[$rule];
                if ($ruleValidator->validate($formData, $fieldName, $ruleParams/*[]*/)) {
                    continue;
                }
                //echo "Error";
                $errors[$fieldName][] = $ruleValidator->getMessage(
                    $formData,
                    $fieldName,
                    $ruleParams
                    //[]
                );
            }
        }
        if (count($errors)) {
            // dd($errors);
            throw new ValidationException($errors);
        }
    }
}
