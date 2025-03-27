<?php

namespace App\Livewire;


use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Unidad;

class UnidadesTable extends DataTableComponent
{
    protected $model = Unidad::class;

    protected $listeners = ['Refresh' => 'refreshTable',];

    private $isRefreshing = false;

    //NO MODIFICAR
    public function refreshTable()
    {
        if ($this->isRefreshing) {
            return;  // Detener si ya está en proceso de refresco
        }

        $this->isRefreshing = true;

        // Tu lógica de refresco aquí

        $this->isRefreshing = false;  // Marcar como finalizado
    }

    //NO MODIFICAR
    // Método para manejar el clic en una fila
    public function getTableRowUrl($row): ?string
    {
        return '#';  // No redirige a ninguna URL
    }

    //Modificar opcionalmente
    // Método para agregar atributos a las filas
    public function setTableRowAttributes($row): array
    {
        return [
            'wire:click.prevent' => 'viewModal(' . $row->id . ')',
            'class' => 'cursor-pointer',
        ];
    }

    public function viewModal($id): void
    {
        $this->dispatch('openUnidadModal', id: $id)->to('unidad-component');
    }

    public function viewShowModal($id): void
    {
        $this->dispatch('openShowUnidadModal', id: $id)->to('unidad-component');
    }

    public function deleteUnidadTable($id): void
    {
        Log::info("ID de la deleteUnidadTable, enviado: " . $id);
        $this->dispatch('borrarRegistro', $id)->to('unidad-component');
        Log::info("deleteUnidadTable enviado a unidad-component " . $id); // Corrige el uso de 'id' para pasar el array
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
            Column::make("Placa", "plate")
                ->searchable()->sortable(),
                Column::make("Capacidad", "capacitance")
                ->format(fn ($value) => "$value pasajeros")
                ->searchable()
                ->sortable(),            
            Column::make("Marca", "brand")
                ->searchable()->sortable(),
            Column::make("Modelo", "model")
                ->searchable()->sortable(),
            Column::make("Año", "year")
                ->searchable()->sortable(),

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
                            'wire:click.prevent' => 'deleteUnidadTable(' . $row->id . ')',
                        ])
                        ->html(),
                ]),
        ];
    }
}
