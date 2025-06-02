<section class="w-full"
         x-data="{
             file_uploaded: @entangle('file_uploaded'),
         }">

    {{-- Page Heading --}}

    @include('partials.admin-heading')

    <x-admin.layout :heading="$title" class="w-full">

        <form wire:submit="save" class="my-6 w-full space-y-6">

            {{-- Template Name --}}
            <flux:input :placeholder="__('My Signature Template')"
                        required autofocus autocomplete="name"
                        wire:model="form.name"
                        :label="__('Name')"
                        type="text"
                        autofocus />

            {{-- Single PDF File upload to use as sample document to test positionning and format --}}

            {{-- Editing; File is already uploaded --}}
            <div x-show="file_uploaded">
                <flux:label>{{ __('Sample PDF file') }}</flux:label>
                <flux:input.group class="mt-1">
                    <flux:input x-bind:placeholder="file_uploaded" disabled />
                    <flux:button x-on:click="file_uploaded=false" icon="arrow-path-rounded-square">{{ __('Change') }}</flux:button>
                </flux:input.group>
            </div>

            {{-- Filepond Upload --}}
            <div x-show="!file_uploaded">
                <x-filepond::upload wire:model="file"
                                    placeholder="{!! __('Drag & Drop your Sample PDF file or <span class=\'filepond--label-action\'> Browse </span>') !!}" />
            </div>

            {{-- Elements (Signatures, Text, Date) --}}
            <div class="space-y-4">

                {{-- Signature Positions --}}
                @forelse ($form->config['signaturePositions'] as $key => $sp)
                    <flux:fieldset class="ps-2 pe-2 lg:ps-4 lg:pe-4 lg:pt-4 bg-zinc-900/20">
                        <flux:legend>{{ __('Signature') }} {{ $key + 1 }}</flux:legend>
                        <div class="grid grid-cols-3 gap-2">
                            <flux:input required :label="__('Page')" wire:model="form.config.signaturePositions.{{ $key }}.signaturePage" />
                            <flux:input required label="X" wire:model="form.config.signaturePositions.{{ $key }}.signatureX" />
                            <flux:input required label="Y" wire:model="form.config.signaturePositions.{{ $key }}.signatureY" />
                            <flux:input required :label="__('Width')" wire:model="form.config.signaturePositions.{{ $key }}.signatureWidth" />
                            <flux:input required :label="__('Height')" wire:model="form.config.signaturePositions.{{ $key }}.signatureHeight" />
                        </div>
                        <div class="flex justify-end w-full mb-2">
                            <flux:button variant="subtle" wire:click="removeSignaturePosition({{ $key }})" size="xs">{{ __('Remove') }}</flux:button>
                        </div>
                    </flux:fieldset>
                @empty
                    <p class="text-sm text-zinc-500">{{ __('No signatures configured') }}</p>
                    <flux:error name="form.config.signaturePositions"></flux:error>
                @endforelse
                <div class="w-full flex">
                    <flux:button class="w-full" wire:click="addSignaturePosition" icon="plus">{{ __('Signature') }}</flux:button>
                </div>

                {{-- Text Elements --}}
                @forelse ($form->config['textElements'] as $key => $te)
                    <flux:fieldset class="ps-2 pe-2 pt-2 lg:ps-4 lg:pe-4 lg:pt-4 rounded-lg bg-blue-800/20">
                        <div class="space-y-2">
                            <flux:input label="{{ __('Label') }} {{ $key + 1 }}" wire:model="form.config.textElements.{{ $key }}.text" />
                            <div class="grid grid-cols-3 gap-2">
                                <flux:input :label="__('Page')" wire:model="form.config.textElements.{{ $key }}.page" />
                                <flux:input label="X" wire:model="form.config.textElements.{{ $key }}.X" />
                                <flux:input label="Y" wire:model="form.config.textElements.{{ $key }}.Y" />
                            </div>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                                <flux:select :label="__('Style')" wire:model="form.config.textElements.{{ $key }}.style" :placeholder="__('Choose style...')">
                                    <flux:select.option value="">{{ __('None') }}</flux:select.option>
                                    <flux:select.option value="B">{{ __('Bold') }}</flux:select.option>
                                    <flux:select.option value="I">{{ __('Italic') }}</flux:select.option>
                                    <flux:select.option value="U">{{ __('Underlined') }}</flux:select.option>
                                    <flux:select.option value="BU">{{ __('Bold and underlined') }}</flux:select.option>
                                    <flux:select.option value="UI">{{ __('Italic and underlined') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Size')" wire:model="form.config.textElements.{{ $key }}.size" :placeholder="__('Choose font size...')">
                                    <flux:select.option value="9">{{ __('Small') }}</flux:select.option>
                                    <flux:select.option value="12">{{ __('Medium') }}</flux:select.option>
                                    <flux:select.option value="15">{{ __('Big') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Color')" wire:model="form.config.textElements.{{ $key }}.color" :placeholder="__('Choose color...')">
                                    <flux:select.option value="black">{{ __('Black') }}</flux:select.option>
                                    <flux:select.option value="red">{{ __('Red') }}</flux:select.option>
                                    <flux:select.option value="green">{{ __('Green') }}</flux:select.option>
                                    <flux:select.option value="blue">{{ __('Blue') }}</flux:select.option>
                                    <flux:select.option value="white">{{ __('White') }}</flux:select.option>
                                    <flux:select.option value="gray">{{ __('Gray') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Fill')" wire:model="form.config.textElements.{{ $key }}.fill" :placeholder="__('Choose fill color...')">
                                    <flux:select.option value="">{{ __('None') }}</flux:select.option>
                                    <flux:select.option value="black">{{ __('Black') }}</flux:select.option>
                                    <flux:select.option value="red">{{ __('Red') }}</flux:select.option>
                                    <flux:select.option value="green">{{ __('Green') }}</flux:select.option>
                                    <flux:select.option value="blue">{{ __('Blue') }}</flux:select.option>
                                    <flux:select.option value="white">{{ __('White') }}</flux:select.option>
                                    <flux:select.option value="gray">{{ __('Gray') }}</flux:select.option>
                                </flux:select>
                            </div>
                            <div class="flex justify-end w-full mb-2">
                                <flux:button variant="subtle" wire:click="removeTextElement({{ $key }})" size="xs">{{ __('Remove') }}</flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                @empty
                @endforelse
                <div class="w-full flex">
                    <flux:button class="w-full" wire:click="addTextElement" icon="plus">{{ __('Text') }}</flux:button>
                </div>

                {{-- Date Elements --}}
                @forelse ($form->config['dateElements'] as $key => $de)
                    <flux:fieldset class="ps-2 pe-2 pt-2 lg:ps-4 lg:pe-4 lg:pt-4 rounded-lg bg-green-800/20">
                        <div class="space-y-2">
                            <flux:input label="{{ __('Date format') }}*" wire:model="form.config.dateElements.{{ $key }}.dateFormat" />
                            <div class="grid grid-cols-3 gap-2">
                                <flux:input :label="__('Page')" wire:model="form.config.dateElements.{{ $key }}.page" />
                                <flux:input label="X" wire:model="form.config.dateElements.{{ $key }}.X" />
                                <flux:input label="Y" wire:model="form.config.dateElements.{{ $key }}.Y" />
                            </div>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-2">
                                <flux:select :label="__('Style')" wire:model="form.config.dateElements.{{ $key }}.style" :placeholder="__('Choose style...')">
                                    <flux:select.option value="">{{ __('None') }}</flux:select.option>
                                    <flux:select.option value="B">{{ __('Bold') }}</flux:select.option>
                                    <flux:select.option value="I">{{ __('Italic') }}</flux:select.option>
                                    <flux:select.option value="BU">{{ __('Underlined') }}</flux:select.option>
                                    <flux:select.option value="BU">{{ __('Bold and underlined') }}</flux:select.option>
                                    <flux:select.option value="UI">{{ __('Italic and underlined') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Size')" wire:model="form.config.dateElements.{{ $key }}.size" :placeholder="__('Choose size...')">
                                    <flux:select.option value="9">{{ __('Small') }}</flux:select.option>
                                    <flux:select.option value="12">{{ __('Medium') }}</flux:select.option>
                                    <flux:select.option value="15">{{ __('Big') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Color')" wire:model="form.config.dateElements.{{ $key }}.color" :placeholder="__('Choose color...')">
                                    <flux:select.option value="black">{{ __('Black') }}</flux:select.option>
                                    <flux:select.option value="red">{{ __('Red') }}</flux:select.option>
                                    <flux:select.option value="green">{{ __('Green') }}</flux:select.option>
                                    <flux:select.option value="blue">{{ __('Blue') }}</flux:select.option>
                                    <flux:select.option value="white">{{ __('White') }}</flux:select.option>
                                    <flux:select.option value="gray">{{ __('Gray') }}</flux:select.option>
                                </flux:select>
                                <flux:select :label="__('Fill')" wire:model="form.config.dateElements.{{ $key }}.fill" :placeholder="__('Choose fill color...')">
                                    <flux:select.option value="">{{ __('None') }}</flux:select.option>
                                    <flux:select.option value="black">{{ __('Black') }}</flux:select.option>
                                    <flux:select.option value="red">{{ __('Red') }}</flux:select.option>
                                    <flux:select.option value="green">{{ __('Green') }}</flux:select.option>
                                    <flux:select.option value="blue">{{ __('Blue') }}</flux:select.option>
                                    <flux:select.option value="white">{{ __('White') }}</flux:select.option>
                                    <flux:select.option value="gray">{{ __('Gray') }}</flux:select.option>
                                </flux:select>
                            </div>

                            <span class="text-xs">* <flux:link variant="subtle" href="https://www.php.net/manual/en/datetime.format.php" target="_blank">Date format reference</flux:link></span>
                            <div class="flex justify-end w-full mb-2">
                                <flux:button variant="subtle" wire:click="removeDateElement({{ $key }})" size="xs">{{ __('Remove') }}</flux:button>
                            </div>
                        </div>
                    </flux:fieldset>
                @empty
                @endforelse
                <div class="w-full flex">
                    <flux:button class="w-full" wire:click="addDateElement" icon="plus">{{ __('Date') }}</flux:button>
                </div>
            </div>

            <div class="flex items-center gap-4 justify-between">

                <div class="flex items-center justify-end gap-2">

                    {{-- Save button --}}
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>

                    {{-- Cancel button --}}
                    <flux:button variant="ghost" type="button" class="w-full" :href="route('signature-templates')">{{ __('Cancel') }}</flux:button>

                </div>

                <x-action-message class="me-3" on="settings-updated">
                    {{ __('Saved.') }}
                </x-action-message>

                {{-- Delete button --}}
                @if ($form->editing)
                    @can('delete', $form->signatureTemplate)
                        <flux:button variant="danger" wire:click.prevent="delete">{{ __('Delete') }}</flux:button>
                    @endcan
                @endif
            </div>
        </form>

    </x-admin.layout>

</section>
