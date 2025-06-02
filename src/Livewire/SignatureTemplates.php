<?php

namespace Jmitech\LaravelSignPad\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;

class SignatureTemplates extends Component
{
	public int $count = 0;

	public bool $can_create = false;

	public function mount(): void
	{
		Gate::authorize('manage signature templates');

		$this->can_create = auth()->user()->can('create', SignatureTemplate::class);

		$this->count = SignatureTemplate::count();
	}

	public function render()
	{
		return view('laravel-sign-pad::signature-templates');
	}
}
