<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Conductor;

class ConductoresTable extends DataTableComponent
{
    protected $model = Conductor::class;

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

    public function viewModal($id): void
    {
        $this->dispatch('openConductorModal', id: $id)->to('conductor-component');
    }

    public function viewShowModal($id): void
    {
        $this->dispatch('openShowConductorModal', id: $id)->to('conductor-component');
    }

    public function deleteConductorTable($id): void
    {
        Log::info("ID de la deleteConductorTable, enviado: " . $id);
        $this->dispatch('borrarRegistro', $id)->to('conductor-component');
        Log::info("deleteConductorTable enviado a conductor-component " . $id);
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

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->hideIf(true),

            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),

            Column::make("Unidad", "route_unit.unit.plate")
                ->searchable()
                ->sortable(),

            Column::make("Día", "schedules.day")
                ->searchable()
                ->sortable(),

            Column::make("Hora Salida", "schedules.departure_time")
                ->searchable()
                ->sortable(),

            Column::make("Hora Llegada", "schedules.arrival_time")
                ->searchable()
                ->sortable(),

            ButtonGroupColumn::make('Acciones')
                ->attributes(fn($row) => ['class' => 'space-x-2'])
                ->buttons([
                    LinkColumn::make('Editar')
                        ->title(fn($row) => '<i class="fas fa-edit"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-warning w-8 h-8 flex items-center justify-center rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Ver')
                        ->title(fn($row) => '<i class="fas fa-info-circle"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-success w-8 h-8 flex items-center justify-center rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewShowModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Eliminar')
                        ->title(fn($row) => '<i class="fas fa-trash"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-danger w-8 h-8 flex items-center justify-center rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'deleteConductorTable(' . $row->id . ')',
                        ])
                        ->html(),
                ]),
        ];
    }
}
