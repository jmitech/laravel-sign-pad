<?php

namespace Jmitech\LaravelPadSign\Validators;

use Jmitech\LaravelSignPad\SignatureTemplate;
use Jmitech\Laravel\Support\Traits\HasValidator;

trait ValidatesSignatureTemplate
{
	public SignatureTemplate $signatureTemplate;
	
	use HasValidator;

	public function rules()
	{
		return [
			'name' => 'required|min:2|max:255',
			'config.signaturePositions' => 'array|required|min:1',
			'config.textElements' => 'array|nullable',
			'config.dateElements' => 'array|nullable',
		];
	}
}
