<?php

namespace Jmitech\LaravelSignPad\Controllers;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\Signature;
use Illuminate\Support\Facades\Storage;

class SignedDocumentDownloadController
{
    public function __invoke(Signature $signature)
    {
        $documents_path = config('sign-pad.documents_path', 'signed_documents');

        Gate::authorize('view', $signature);

        $filepath = "{$documents_path}/{$signature->document_filename}";

        return Storage::download($filepath);
    }
}
