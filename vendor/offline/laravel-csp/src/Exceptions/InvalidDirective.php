<?php

namespace OFFLINE\LaravelCSP\Exceptions;

use Exception;

class InvalidDirective extends Exception
{
    public static function notSupported(string $directive): self
    {
        return new self("The directive `{$directive}` is not valid in a CSP header. ");
    }
}
