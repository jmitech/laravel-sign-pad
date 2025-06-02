<?php

namespace Jmitech\LaravelSignPad\Controllers;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\Signature;
use Illuminate\Support\Facades\Storage;
use Jmitech\LaravelSignPad\Exceptions\SignatureDocumentNotFoundException;
use Jmitech\LaravelSignPad\Exceptions\SignatureDocumentFileNotFoundInStorageException;

class SignedDocumentOpenContoller
{
    public function __invoke(Signature $signature)
    {
        Gate::authorize('view', $signature);

        $filename = $signature->document_filename ?? false;

        if (!$filename)
            throw new SignatureDocumentNotFoundException("Signed Document for signature #{$signature->id} not generated");

        $documents_path = config('sign-pad.documents_path', 'signed_documents');

        $filepath = "{$documents_path}/$filename";

        $file = Storage::get($filepath);

        if (!$file)
            throw new SignatureDocumentFileNotFoundInStorageException("Signed Document File for signature #{$signature->id} not found in storage at {$documents_path}");

        return response($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
            'Content-Length' => strlen($file),
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => '0',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
            'Referrer-Policy' => 'no-referrer',
            'Content-Security-Policy' => "default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:; frame-ancestors 'none';",
            'Feature-Policy' => "geolocation 'none'; microphone 'none'; camera 'none';",
            'Permissions-Policy' => "geolocation=(self), microphone=(), camera=()",
        ]);
    }
}
