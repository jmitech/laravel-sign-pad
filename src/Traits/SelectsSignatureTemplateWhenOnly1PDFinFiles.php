<?php

namespace Jmitech\LaravelSignPad\Traits;

use Livewire\Attributes\Computed;

trait SelectsSignatureTemplateWhenOnly1PDFinFiles
{
	// parent must have a `public array $files = [];` property
	
	public ?int $signature_template_id = null;

	#[Computed]
	public function is_signable_file(): bool
	{
		return (bool)(count($this->files) == 1 and $this->files[0]->getMimeType() == 'application/pdf');
	}

	public function resetSignatureTemplate(): void
	{
		$this->signature_template_id = null;

		unset($this->is_signable_file);
	}
}
