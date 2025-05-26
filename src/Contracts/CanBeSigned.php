<?php

namespace Jmitech\LaravelSignPad\Contracts;

interface CanBeSigned
{
    public function getSignatureRoute(): string;

    public function hasBeenSigned(): bool;
}
