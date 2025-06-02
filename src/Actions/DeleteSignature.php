<?php

namespace Jmitech\LaravelSignPad\Actions;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\Signature;

class DeleteSignature
{
	public function __invoke(Signature $signature)
	{
		Gate::authorize('delete', $signature);

		$signature->delete();
	}
}
