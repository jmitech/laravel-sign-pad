<?php

namespace Jmitech\LaravelSignPad\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use Jmitech\LaravelSignPad\SignatureTemplate;
use Livewire\Features\SupportRedirects\Redirector;
use Jmitech\LaravelSignPad\Concerns\HasSignatureTemplateForm;
use Jmitech\LaravelPadSign\Actions\SignatureTemplates\DeleteSignatureTemplateAction;

class EditSignatureTemplate extends Component
{
	use HasSignatureTemplateForm;

	public function mount(SignatureTemplate $Template): void
	{
		Gate::authorize('update', $Template);

		$this->title = __('Edit Signature Template #:id', ['id' => $Template->id]);

		$this->form->setTemplate($Template, editing: true);

		$this->file_uploaded = $Template->sample_pdf->file_name ??  false;
	}

	public function delete(): RedirectResponse|Redirector
	{
		app(DeleteSignatureTemplateAction::class)($this->form->signatureTemplate);

		return redirect()->route('signature-templates');
	}
}
