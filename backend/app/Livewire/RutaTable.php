<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ruta;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class RutaTable extends DataTableComponent
{
    protected $model = Ruta::class;

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

    public function viewModal($rutaId): void
    {
        $this->dispatch('openRutaModal', rutaId: $rutaId)->to('ruta-component');
    }

    public function viewShowModal($rutaId): void
    {
        $this->dispatch('openShowRutaModal', rutaId: $rutaId)->to('ruta-component');
    }

    public function deleteRutaTable($rutaId): void
    {
        $this->dispatch('borrarRegistro', rutaId: $rutaId)->to('ruta-component');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->hideIf(true),
            Column::make("Fare ID", "fare_id")
                ->searchable()
                ->sortable(),
            Column::make("Origen Localidad ID", "origin_locality_id")
                ->searchable()
                ->sortable(),
            Column::make("Destino Localidad ID", "destination_locality_id")
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
                            'wire:click.prevent' => 'deleteRutaTable(' . $row->id . ')',
                        ])
                        ->html(),
                ])
        ];
    }
}