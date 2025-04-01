<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use App\Models\Envio;

class EnviosTable extends DataTableComponent
{
    protected $model = Envio::class;

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
        $this->dispatch('openEnvioModal', id: $id)->to('envio-component');
    }

    public function viewShowModal($id): void
    {
        $this->dispatch('openShowEnvioModal', id: $id)->to('envio-component');
    }

    public function deleteEnvioTable($id): void
    {
        Log::info("ID de la deleteEnvioTable, enviado: " . $id);
        $this->dispatch('borrarRegistro', id: $id)->to('envio-component');
        Log::info("deleteEnvioTable enviado a envio-component " . $id);
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
            Column::make("Id", "id")->hideIf(true),
            Column::make("Remitente", "sender_name")->searchable()->sortable(),
            Column::make("Receptor", "receiver_name")->searchable()->sortable(),
            Column::make("Total", "total")->searchable()->sortable(),
            Column::make("Foto", "photo")->searchable()->sortable(),
            Column::make("Descripción", "description")->searchable()->sortable(),
            Column::make("Route unit id", "route_unit_id")->searchable()->sortable(),
            Column::make("Schedule id", "schedule_id")->searchable()->sortable(),
            Column::make("Route id", "route_id")->searchable()->sortable(),

            ButtonGroupColumn::make('Acciones')
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
                            'class' => 'btn btn-success w-8 h-8 flex items-center justify-center rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewShowModal(' . $row->id . ')',
                        ])
                        ->html(),
                    LinkColumn::make('Delete')
                        ->title(fn($row) => '<i class="fas fa-trash"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-danger w-8 h-8 flex items-center justify-center rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'deleteEnvioTable(' . $row->id . ')',
                        ])
                        ->html(),
                ]),
        ];
    }
}
