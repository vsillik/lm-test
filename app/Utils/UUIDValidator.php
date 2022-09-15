<?php

namespace App\Utils;

use Nette\Utils\Validators;

class UUIDValidator
{
    /**
     * Validates string whether is uuid (hyphens are optional, and can be placed anywhere but on the beginning and on the end)
     * @param string $uuid
     * @return bool
     */
    public static function validate(string $uuid): bool
    {
       return (preg_match('/^{?([a-fA-F0-9]-?){31}[a-fA-F0-9]}?$/', $uuid) === 1);
    }
}