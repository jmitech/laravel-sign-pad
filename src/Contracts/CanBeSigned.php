<?php

namespace Jmitech\LaravelSignPad\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphOne;

interface CanBeSigned
{
    public function deleteSignature(): bool;

    public function getSignatureRoute(): string;

    public function hasBeenSigned(): bool;

    public function isDeletable(): bool;

    public function isSignable(): bool;

    public function signature_config(): ?MorphOne;

    public function signatureIsRequired(): bool; // when this modeal hasOne relation SignatureRequirement

    public function signature(): ?MorphOne;
}
