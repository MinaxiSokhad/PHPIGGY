<?php

declare(strict_types=1);

namespace Framework\Contracts;

interface RuleInterface //create ruleInterface For validating the rule for registration form
{
    public function validate(array $data, string $field, array $params): bool;
    public function getMessage(array $data, string $field, array $params): string;
}
