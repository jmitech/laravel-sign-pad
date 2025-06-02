<?php

if (! function_exists('signature_templates')) {
	function signature_templates(): Illuminate\Support\Collection
	{
		return Jmitech\LaravelSignPad\SignatureTemplate::all();
	}
}
