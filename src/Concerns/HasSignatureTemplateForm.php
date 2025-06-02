<?php

namespace Jmitech\LaravelSignPad\Concerns;

use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Spatie\LivewireFilepond\WithFilePond;
use Illuminate\Validation\ValidationException;
use Jmitech\Laravel\Notifications\Facades\Toast;
use Jmitech\LaravelSignPad\Livewire\Forms\SignatureTemplateForm;
use Jmitech\Laravel\Notifications\Traits\DispatchesUxNotificationsLivewireEvents;
use Jmitech\LaravelPadSign\Actions\SignatureTemplates\SaveSampleSignatureTemplateFileUploadAction;

trait HasSignatureTemplateForm
{
	use DispatchesUxNotificationsLivewireEvents,
		WithFileUploads,
		WithFilePond;

	public SignatureTemplateForm $form;

	public string $title = '';

	public bool|string $file_uploaded = false;

	#[Validate('nullable|mimes:pdf|max:15000')]
	public $file;

	public function addSignaturePosition(): void
	{
		$this->form->config['signaturePositions'][] = [
			'signaturePage' => 1,
			'signatureX' => 50,
			'signatureY' => 80,
			'signatureWidth' => config('sign-pad.width', 600),
			'signatureHeight' => config('sign-pad.height', 200),
		];
	}

	public function addTextElement(): void
	{
		$this->form->config['textElements'][] = [
			'text' => '',
			'page' => 1,
			'X' => 100,
			'Y' => 100,
			'size' => 12,
			'color' => 'blue',
			'style' => 'B',
			'fill' => '',
		];
	}

	public function addDateElement(): void
	{
		$this->form->config['dateElements'][] = [
			'dateFormat' => 'Y-m-d H:i:s',
			'page' => 1,
			'X' => 60,
			'Y' => 60,
			'size' => 12,
			'color' => 'black',
			'style' => '',
			'fill' => '',
		];
	}

	public function removeSignaturePosition($key): void
	{
		unset($this->form->config['signaturePositions'][$key]);
	}

	public function removeTextElement($key): void
	{
		unset($this->form->config['textElements'][$key]);
	}

	public function removeDateElement($key): void
	{
		unset($this->form->config['dateElements'][$key]);
	}

	public function validateUploadedFile()
	{
		try {
			$this->validateOnly('file');
			return true;
		} catch (ValidationException $e) {
			$message = collect($e->validator->errors()->all())->first() ?? __('Validation error');
			$this->notification(Toast::colorfulError($message)->quick());
			return false;
		}
	}

	public function save()
	{
		$this->form->validate();

		if ($this->form->editing)
			$template = $this->form->update();
		else
			$template = $this->form->store();

		app(SaveSampleSignatureTemplateFileUploadAction::class)($template, $this->file);

		$message = $this->form->editing
			? __('Signature template :name updated', ['name' => $this->form->name])
			: __('Signature template :name created', ['name' => $this->form->name]);

		$this->notification(Toast::success($message)->quick());

		return redirect()->route('signature-templates');
	}

	public function render()
	{
		return view('laravel-sign-pad::signature-template-form')
			->title($this->title);
	}
}
