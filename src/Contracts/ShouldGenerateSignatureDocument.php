<?php

namespace Jmitech\LaravelSignPad\Contracts;

use Jmitech\LaravelSignPad\SignatureDocumentTemplate;

interface ShouldGenerateSignatureDocument
{
    public function getSignatureDocumentTemplate(): SignatureDocumentTemplate;
}
