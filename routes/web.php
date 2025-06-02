<?php

use Illuminate\Support\Facades\Route;
use Jmitech\LaravelSignPad\Livewire\EditSignatureTemplate;
use Jmitech\LaravelSignPad\Livewire\CreateSignatureTemplate;
use Jmitech\LaravelSignPad\Controllers\LaravelSignPadController;
use Jmitech\LaravelSignPad\Controllers\SignedDocumentOpenContoller;
use Jmitech\LaravelSignPad\Controllers\SignedDocumentDownloadController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {

	// Sign Pad request

	Route::post('creagia/sign-pad', LaravelSignPadController::class)->name('sign-pad::signature');

	// Signatures

	Route::get('signature/{signature}/download', SignedDocumentDownloadController::class)->name('download-signature');

	Route::get('signature/{signature}/open', SignedDocumentOpenContoller::class)->name('open-signature');

	// Signatures Templates

	Route::middleware(['can:manage signature templates'])->group(function () {

		Route::get('signature-templates/create', CreateSignatureTemplate::class)->name('signature-templates.create');

		Route::get('signature-templates/{Template}', EditSignatureTemplate::class)->name('signature-templates.edit');
	});
});
