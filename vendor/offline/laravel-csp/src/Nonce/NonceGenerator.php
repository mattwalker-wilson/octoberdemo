<?php

namespace OFFLINE\LaravelCSP\Nonce;

interface NonceGenerator
{
    public function generate(): string;
}
