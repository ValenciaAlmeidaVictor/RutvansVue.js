<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoTarifa;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class TipoTarifasTable extends DataTableComponent
{
    protected $model = TipoTarifa::class;
    protected $listeners = ['Refresh' => 'refreshTable'];

    private $isRefreshing = false;

    public function refreshTable()
    {
        if ($this->isRefreshing) {
            return;
        }
        $this->isRefreshing = true;
        $this->isRefreshing = false;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setTableAttributes([
                'class' => 'table-auto table-bordered table-striped',
            ])
            ->setTheadAttributes([
                'class' => 'thead-dark'
            ])
            ->setDefaultSort('id', 'asc')
            ->setSortingPillsStatus(false)
            ->setPerPageAccepted([10, 25, 50, 100])
            ->setPerPage(10)
            ->setLayout('layouts.app')
            ->setBulkActionsEnabled()
            ->setHideBulkActionsWhenEmptyEnabled();
    }

    public function getTableRowUrl($row): ?string
    {
        return '#';
    }

    public function setTableRowAttributes($row): array
    {
        return [
            'wire:click.prevent' => 'viewModal(' . $row->id . ')',
            'class' => 'cursor-pointer',
        ];
    }

    public function viewModal($tipoTarifaId): void
    {
        $this->dispatch('openTipoTarifaModal', tipoTarifaId: $tipoTarifaId)->to('tipo-tarifa-component');
    }

    public function viewShowModal($tipoTarifaId): void
    {
        $this->dispatch('openShowTipoTarifaModal', tipoTarifaId: $tipoTarifaId)->to('tipo-tarifa-component');
    }

    public function deleteTipoTarifaTable($tipoTarifaId): void
    {
        $this->dispatch('borrarRegistro', tipoTarifaId: $tipoTarifaId)->to('tipo-tarifa-component');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->hideIf(true),
            Column::make("Name", "name")
                ->searchable()
                ->sortable(),
            Column::make("Percentage", "percentage")
                ->searchable()
                ->sortable(),
            Column::make("Description", "description")
                ->searchable()
                ->sortable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(fn($row) => ['class' => 'space-x-2'])
                ->buttons([
                    LinkColumn::make('Edit')
                        ->title(fn($row) => '<i class="fas fa-edit"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-warning w-8 h-8 flex items-center justify-center rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Show')
                        ->title(fn($row) => '<i class="fas fa-info-circle"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-success  w-8 h-8 flex items-center justify-center rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewShowModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Delete')
                        ->title(fn($row) => '<i class="fas fa-trash"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-danger  w-8 h-8 flex items-center justify-center rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'deleteTipoTarifaTable(' . $row->id . ')',
                        ])
                        ->html(),
                ])
        ];
    }
}