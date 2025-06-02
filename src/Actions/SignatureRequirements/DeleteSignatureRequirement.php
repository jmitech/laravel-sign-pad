<?php

namespace Jmitech\LaravelSignPad\Actions\SignatureRequirements;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureRequirement;

class DeleteSignatureRequirement
{
	public function __invoke(SignatureRequirement $signature_config)
	{
		Gate::authorize('delete', $signature_config);

		$signature_config->delete();
	}
}
