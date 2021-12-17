<?php

namespace OFFLINE\LaravelCSP\Nonce;

use Illuminate\Support\Str;

class RandomString implements NonceGenerator
{
    public function generate(): string
    {
        return Str::random(32);
    }
}
