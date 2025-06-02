<?php

namespace Jmitech\LaravelSignPad\Livewire\Forms;

use Livewire\Form;
use Jmitech\LaravelSignPad\SignatureTemplate;
use App\Models\Validators\ValidatesSignatureTemplate;
use Jmitech\LaravelPadSign\Actions\SignatureTemplates\StoreSignatureTemplateAction;
use Jmitech\LaravelPadSign\Actions\SignatureTemplates\UpdateSignatureTemplateAction;

class SignatureTemplateForm extends Form
{
    use ValidatesSignatureTemplate;

    public bool $editing = false;

    public string $name;

    public array $config = [
        'signaturePositions' => [],
        'textElements' => [],
        'dateElements' => [],
    ];

    public function setTemplate(SignatureTemplate $signatureTemplate, bool $editing = false)
    {
        $this->editing = $editing;

        $this->signatureTemplate = $signatureTemplate;

        $this->name = $signatureTemplate->name;
        
        $this->config = $signatureTemplate->config;
    }

    public function store(): SignatureTemplate
    {
        $data = $this->validate();

        return app(StoreSignatureTemplateAction::class)($data);
    }

    public function update(): SignatureTemplate
    {
        $data = $this->validate();

        return app(UpdateSignatureTemplateAction::class)($this->signatureTemplate, $data);
    }
}
