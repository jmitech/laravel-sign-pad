<?php

namespace Jmitech\LaravelSignPad\Actions\SignatureRequirements;

use App\Models\File;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureRequirement;

class ApplySignatureRequirement
{
	public function __invoke(File $file, HasMedia $model, int $signature_template_id): bool|SignatureRequirement
	{
		Gate::authorize('update', $model);

		Gate::authorize('create', SignatureRequirement::class);

		return $file->signature_config()->updateOrCreate([
			'model_type' => $model::class,
			'model_id' => $model->id,
		], [
			'signature_template_id' => $signature_template_id,
		]);
	}
}
