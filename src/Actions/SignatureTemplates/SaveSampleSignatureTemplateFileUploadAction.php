<?php

namespace Jmitech\LaravelPadSign\Actions\SignatureTemplates;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;

class SaveSampleSignatureTemplateFileUploadAction
{
	public function __invoke(SignatureTemplate $template, mixed $file = null)
	{
		Gate::authorize('update', $template);

		if ($file) {
			$template->clearMediaCollection(SignatureTemplate::collectionName);

			$sample_pdf = $template->addMedia($file)->toMediaCollection(SignatureTemplate::collectionName);

			$sample_pdf->signature_config()->updateOrCreate([
				'signature_template_id' => $template->id,
			]);
		}
	}
}
