<?php

namespace Jmitech\LaravelSignPad\Traits;

use Jmitech\LaravelSignPad\Signature;
use Jmitech\LaravelSignPad\DateElement;
use Jmitech\LaravelSignPad\TextElement;
use Jmitech\LaravelSignPad\SignaturePosition;
use Jmitech\LaravelSignPad\SignatureRequirement;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Jmitech\LaravelSignPad\SignatureDocumentTemplate;
use Jmitech\LaravelSignPad\Templates\PdfDocumentTemplate;

trait SignableModel
{
    public function deleteSignature(): bool
    {
        return $this->signature?->delete() ?? false;
    }

    public function getSignatureDocumentTemplate(): SignatureDocumentTemplate
    {
        $template = $this->signature_config->template->config;

        $signaturePositions = [];
        $textElements = [];
        $dateElements = [];

        foreach ($template['signaturePositions'] as $position) {
            $signaturePositions[] = new SignaturePosition(
                signaturePage: $position['signaturePage'],
                signatureX: $position['signatureX'],
                signatureY: $position['signatureY'],
                signatureWidth: $position['signatureWidth'],
                signatureHeight: $position['signatureHeight'],
            );
        }

        foreach ($template['textElements'] as $element) {
            $textElements[] = new TextElement(
                page: $element['page'],
                text: $element['text'],
                X: $element['X'],
                Y: $element['Y'],
                style: strtoupper($element['style'] ?? ''),
                size: $element['size'],
                color: $element['color'],
                fill: $element['fill'] ?? '',
            );
        }

        foreach ($template['dateElements'] as $element) {
            $dateElements[] = new DateElement(
                page: $element['page'],
                dateFormat: $element['dateFormat'],
                X: $element['X'],
                Y: $element['Y'],
                style: strtoupper($element['style'] ?? ''),
                size: $element['size'],
                color: $element['color'],
                fill: $element['fill'] ?? '',
            );
        }

        return new SignatureDocumentTemplate(
            outputPdfPrefix: __('Signed'), // optional
            template: new PdfDocumentTemplate($this->getPath()),
            signaturePositions: $signaturePositions,
            textElements: $textElements,
            dateElements: $dateElements,
        );
    }

    public function getSignatureRoute(): string
    {
        return route('sign-pad::signature', [
            'model' => get_class($this),
            'id' => $this->id,
            'token' => md5(config('app.key') . get_class($this)),
        ]);
    }

    public function hasBeenSigned(): bool
    {
        return ! is_null($this->signature);
    }

    public function isDeletable(): bool
    {
        return empty($this->signature_config) and empty($this->signature);
    }

    public function isNotSignable(): bool
    {
        return !$this->isSignable();
    }

    public function isSignable(): bool // override me in model
    {
        return true;
    }

    public function signature_config(): ?MorphOne
    {
        return $this->morphOne(SignatureRequirement::class, 'model');
    }

    public function signature(): ?MorphOne
    {
        return $this->morphOne(Signature::class, 'model');
    }

    public function signatureIsRequired(): bool
    {
        if ($this->isNotSignable())
            return false;

        return $this->signature_config ? true : false;
    }
}
