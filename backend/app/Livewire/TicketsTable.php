<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use App\Models\Ticket;

class TicketsTable extends DataTableComponent
{
    protected $model = Ticket::class;

    protected $listeners = ['Refresh' => 'refreshTable'];

    private $isRefreshing = false;

    public function refreshTable()
    {
        if ($this->isRefreshing) return;

        $this->isRefreshing = true;
        $this->isRefreshing = false;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setTableAttributes(['class' => 'table-auto table-bordered table-striped'])
             ->setTheadAttributes(['class' => 'thead-dark'])
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

    public function viewModal($id): void
    {
        $this->dispatch('openTicketModal', id: $id)->to('ticket-component');
    }

    public function viewShowModal($id): void
    {
        $this->dispatch('openShowTicketModal', id: $id)->to('ticket-component');
    }

    public function deleteTicketTable($id): void
    {
        Log::info("ID a borrar (ticket): " . $id);
        $this->dispatch('borrarRegistro', $id)->to('ticket-component');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->hideIf(true),
            Column::make("Pasajero", "passenger_name")->searchable()->sortable(),
            Column::make("Total", "total")->searchable()->sortable(),
            Column::make("Ruta", "route.name")->searchable()->sortable(),
            Column::make("Horario", "schedule.time")->searchable()->sortable(),
            Column::make("Unidad", "routeUnit.unit.name")->searchable()->sortable(),
            Column::make("Destino Intermedio", "intermediateDestination.name")->searchable()->sortable(),

            ButtonGroupColumn::make('Acciones')
                ->attributes(fn($row) => ['class' => 'space-x-2'])
                ->buttons([
                    LinkColumn::make('Editar')
                        ->title(fn($row) => '<i class="fas fa-edit"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-warning w-8 h-8 flex items-center justify-center rounded-md hover:bg-yellow-700',
                            'wire:click.prevent' => 'viewModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Ver')
                        ->title(fn($row) => '<i class="fas fa-info-circle"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-success w-8 h-8 flex items-center justify-center rounded-md hover:bg-blue-700',
                            'wire:click.prevent' => 'viewShowModal(' . $row->id . ')',
                        ])
                        ->html(),

                    LinkColumn::make('Borrar')
                        ->title(fn($row) => '<i class="fas fa-trash"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-danger w-8 h-8 flex items-center justify-center rounded-md hover:bg-red-700',
                            'wire:click.prevent' => 'deleteTicketTable(' . $row->id . ')',
                        ])
                        ->html(),
                ]),
        ];
    }
}
