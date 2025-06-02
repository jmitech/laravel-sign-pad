<?php

namespace Jmitech\LaravelPadSign\Actions\SignatureTemplates;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;
use App\Models\Validators\ValidatesSignatureTemplate;

class UpdateSignatureTemplateAction
{
	use ValidatesSignatureTemplate;

	public function __invoke(SignatureTemplate $template, array $data): SignatureTemplate
	{
		$this->signatureTemplate = $template;

		Gate::authorize('update', $template);
		
		$this->runValidatorWith($data);

		$template->update($data);

		return $template;
	}
}
