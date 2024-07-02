<?php

declare(strict_types=1);
function dd(mixed $value)
{ //create sugar function 
    echo "<pre>";
    var_dump($value);
    echo "<pre>";
    die();
}
function e(mixed $value): string
{
    return htmlspecialchars((string) $value);
}
function redirectTo(string $path)
{
    http_response_code(302);
    header("Location:{$path}"); //redirection with headers
    exit;
}
