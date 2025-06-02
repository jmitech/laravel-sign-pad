<?php

namespace Jmitech\LaravelSignPad;

use Livewire\Livewire;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use Jmitech\LaravelSignPad\Commands\InstallCommand;
use Jmitech\LaravelSignPad\Components\SignaturePad;
use Jmitech\LaravelSignPad\Policies\SignaturePolicy;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Jmitech\LaravelSignPad\Livewire\EditSignatureTemplate;
use Jmitech\LaravelSignPad\Livewire\SignatureTemplatesTable;
use Jmitech\LaravelSignPad\Livewire\CreateSignatureTemplate;
use Jmitech\LaravelSignPad\Policies\SignatureTemplatePolicy;
use Jmitech\LaravelSignPad\Policies\SignatureRequirementPolicy;

class LaravelSignPadServiceProvider extends PackageServiceProvider
{
    public function bootingPackage(): void
    {
        Gate::policy(Signature::class, config('sign-pad.signature_policy', SignaturePolicy::class));

        Gate::policy(SignatureTemplate::class, config('sign-pad.signature_template_policy', SignatureTemplatePolicy::class));

        Gate::policy(SignatureRequirement::class, config('sign-pad.signature_requirement_policy', SignatureRequirementPolicy::class));

        Livewire::component('signature-templates-table', SignatureTemplatesTable::class);

        Livewire::component('create-signature-template', CreateSignatureTemplate::class);

        Livewire::component('edit-signature-template', EditSignatureTemplate::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-sign-pad')
            ->hasConfigFile()
            ->hasViews('laravel-sign-pad')
            ->hasRoute('web')
            ->hasRoutes()
            ->hasAssets()
            ->hasViewComponent('creagia', SignaturePad::class)
            ->hasMigration('create_signatures_table')
            ->hasMigration('create_signature_templates_table')
            ->hasMigration('create_signature_requirements_table')
            ->hasCommand(InstallCommand::class);
    }
}
