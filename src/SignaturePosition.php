<?php

namespace Creagia\LaravelSignPad;

class SignaturePosition
{
    public function __construct(
        public int $signaturePage,
        public int $signatureX,
        public int $signatureY,
        public int $signatureWidth,
        public int $signatureHeight,
    ) {}
}
