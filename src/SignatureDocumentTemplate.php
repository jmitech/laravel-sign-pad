<?php

namespace Jmitech\LaravelSignPad;

use Jmitech\LaravelSignPad\Templates\DocumentTemplate;

class SignatureDocumentTemplate
{
    /**
     * @param  array<SignaturePosition>  $signaturePositions
     */
    public function __construct(
        public string $outputPdfPrefix,
        public DocumentTemplate $template,
        public array $signaturePositions = [],
        public array $textElements = [],
        public array $dateElements = [],
    ) {}
}
