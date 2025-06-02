<section class="w-full">

    @include('partials.admin-heading')

    <x-admin.layout :heading="__('Signature Templates')" :subheading="__('Configure signatures/text/date positions and styling with signature templates.')" class="w-full">

        @if ($can_create)
            <flux:button icon="plus" class="mb-2" variant="primary" :href="route('signature-templates.create')">
                {{ __('Create a new template') }}
            </flux:button>
        @endif

        @if ($count > 0)
            <livewire:signature-templates-table />
        @endif

    </x-admin.layout>

</section>
