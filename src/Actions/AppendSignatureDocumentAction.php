<?php

namespace Creagia\LaravelSignPad\Actions;

use App\Models\SignatureTemplate;
use Creagia\LaravelSignPad\Exceptions\InvalidConfiguration;
use Creagia\LaravelSignPad\SignatureDocumentTemplate;
use Exception;
use setasign\Fpdi\Tcpdf\Fpdi;

class AppendSignatureDocumentAction
{
    /**
     * @throws InvalidConfiguration
     * @throws Exception
     */
    public function __invoke(Fpdi $pdf, string $decodedImage, SignatureDocumentTemplate $signatureTemplate): Fpdi
    {
        $this->validateConfig($signatureTemplate);

        foreach ($signatureTemplate->signaturePositions as $signaturePosition) {
            $pdf->setPage($signaturePosition->signaturePage);

            $pdf->Image(
                '@' . $decodedImage,
                $signaturePosition->signatureX,
                $signaturePosition->signatureY,
                $signaturePosition->signatureWidth * 0.26458333 / 2,
                $signaturePosition->signatureHeight * 0.26458333 / 2,
                'PNG'
            );

            if (config('sign-pad.certify_documents')) {
                // Define active area for signature
                $pdf->setSignatureAppearance(
                    $signaturePosition->signatureX,
                    $signaturePosition->signatureY,
                    $signaturePosition->signatureWidth * 0.26458333 / 2,
                    $signaturePosition->signatureHeight * 0.26458333 / 2,
                );
            }
        }

        return $pdf;
    }

    private function validateConfig(SignatureDocumentTemplate $signatureTemplate): void
    {
        foreach ($signatureTemplate->signaturePositions as $signaturePosition) {
            if (! is_numeric($signaturePosition->signaturePage)) {
                throw new InvalidConfiguration("Invalid sign pad page. Check your SignatureTemplate object");
            }
            if (! is_numeric($signaturePosition->signatureX)) {
                throw new InvalidConfiguration("Invalid sign pad X position. Check your SignatureTemplate object");
            }
            if (! is_numeric($signaturePosition->signatureY)) {
                throw new InvalidConfiguration("Invalid sign pad Y position. Check your SignatureTemplate object");
            }
        }

        if (! is_bool(config('sign-pad.certify_documents'))) {
            throw new InvalidConfiguration("Invalid boolean value. Check your config key 'sign-pad.certify_documents'");
        }
    }
}
