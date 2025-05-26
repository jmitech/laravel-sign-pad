<?php

namespace Jmitech\LaravelSignPad\Templates;

use Jmitech\LaravelSignPad\Actions\AppendSignatureDocumentAction;
use Jmitech\LaravelSignPad\Actions\CertifyDocumentAction;
use Jmitech\LaravelSignPad\Signature;
use Jmitech\LaravelSignPad\SignatureDocumentTemplate;
use setasign\Fpdi\Tcpdf\Fpdi;
use Jmitech\LaravelSignPad\Actions\AppendTextDocumentAction;
use Jmitech\LaravelSignPad\Actions\AppendDateDocumentAction;

abstract class DocumentTemplate
{
    /**
     * @phpstan-param view-string $path
     */
    public function __construct(
        public string $path
    ) {}

    abstract public function appendPages(Fpdi $pdf, Signature $signature): Fpdi;

    public function certify(Fpdi $pdf): Fpdi
    {
        return app(CertifyDocumentAction::class)($pdf);
    }

    public function appendSignature(Fpdi $pdf, string $decodedImage, SignatureDocumentTemplate $signatureDocumentTemplate): Fpdi
    {
        return app(AppendSignatureDocumentAction::class)($pdf, $decodedImage, $signatureDocumentTemplate);
    }

    public function appendText(Fpdi $pdf, SignatureDocumentTemplate $signatureDocumentTemplate): Fpdi
    {
        return app(AppendTextDocumentAction::class)($pdf, $signatureDocumentTemplate);
    }

    public function appendDate(Fpdi $pdf, SignatureDocumentTemplate $signatureDocumentTemplate): Fpdi
    {
        return app(AppendDateDocumentAction::class)($pdf, $signatureDocumentTemplate);
    }
}
