<?php

namespace Jmitech\LaravelSignPad\Livewire;

use Illuminate\Support\Facades\Gate;
use Jmitech\LaravelSignPad\SignatureTemplate;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class SignatureTemplatesTable extends DataTableComponent
{
    public array $templates = [];

    public $model = SignatureTemplate::class;

    public $columnSearch = [
        'name' => null,
    ];

    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];

    public function mount(): void
    {
        Gate::authorize('viewAny', $this->model);
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableRowUrl(function ($row) {
                return route('signature-templates.edit', ['Template' => $row->id]);
            });

        $this->setSearchDisabled();

        $this->setHideBulkActionsWhenEmptyEnabled();

        $this->setColumnSelectDisabled();

        $this->setPaginationMethod('simple');

        $this->setPerPageVisibilityDisabled();

        $this->setBulkActionsDisabled();
    }

    public function deleteSelected(): void
    {
        foreach ($this->getSelected() as $item) {
            $st = SignatureTemplate::find($item);
            if ($st)
                $st->delete();
        }
        $this->setBulkActionsStatus(false);

        $this->dispatch('$refresh');
    }

    public function columns(): array
    {
        return [
            Column::make(__('Name'), 'name')->sortable()->searchable(),

            LinkColumn::make('Action')
                ->title(fn($row) => @$row->sample_pdf ?  __('Test template') : '')
                ->location(fn($row) => @$row->sample_pdf ? route('file', ['File' => $row->sample_pdf->id]) : false)
                ->attributes(fn($row) => [
                    'class' => 'text-blue-500 hover:text-blue-600',
                ]),

            Column::make(__('Date created'), 'created_at')->sortable(),

            Column::make(__('ID'), 'id')->hideIf(true),
        ];
    }
}
