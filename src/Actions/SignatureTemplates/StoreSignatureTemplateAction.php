<?php

namespace Jmitech\LaravelPadSign\Actions\SignatureTemplates;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;
use App\Models\Validators\ValidatesSignatureTemplate;

class StoreSignatureTemplateAction
{
	use ValidatesSignatureTemplate;

	public function __invoke(array $data): SignatureTemplate
	{
		$this->signatureTemplate = new SignatureTemplate();

		Gate::authorize('create', SignatureTemplate::class);

		$this->runValidatorWith($data);

		return SignatureTemplate::create($data);
	}
}
