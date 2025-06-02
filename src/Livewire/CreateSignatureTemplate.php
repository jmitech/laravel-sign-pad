<?php

namespace Jmitech\LaravelSignPad\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;
use Jmitech\LaravelSignPad\Concerns\HasSignatureTemplateForm;

class CreateSignatureTemplate extends Component
{
	use HasSignatureTemplateForm;

	public function mount(): void
	{
		Gate::authorize('create', SignatureTemplate::class);
		
		$this->title = __('Create Signature Template');
	}

	public function render()
	{
		return view('laravel-sign-pad::signature-template-form')
			->title($this->title);
	}
}
