<?php
declare(strict_types=1);
namespace Framework\Rules;
use Framework\Contracts\RuleInterface;

class AgeRule implements RuleInterface{
    private array $ageErr = [];
    public function validate(array $data, string $field, array $params): bool
    {
        $age = $data[$field];
        if (!preg_match("/\d/", $age)) {
            $this->ageErr[] = "age should contain only digit";
        }
        return empty($this->ageErr);
    }
    public function getMessage(array $data, string $field, array $params): string{
        return implode(',',$this->ageErr);
    }
}