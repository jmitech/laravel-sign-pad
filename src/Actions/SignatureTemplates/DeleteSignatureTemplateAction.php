<?php

namespace Jmitech\LaravelPadSign\Actions\SignatureTemplates;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;

class DeleteSignatureTemplateAction
{
	public function __invoke(SignatureTemplate $signatureTemplate)
	{
		Gate::authorize('delete', $signatureTemplate);

		$signatureTemplate->delete();
	}
}
