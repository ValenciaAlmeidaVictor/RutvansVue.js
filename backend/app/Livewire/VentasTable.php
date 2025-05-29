<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use App\Models\Venta;

class VentasTable extends DataTableComponent
{
    protected $model = Venta::class;

    protected $listeners = ['Refresh' => 'refreshTable',];

    private $isRefreshing = false;

    public function refreshTable()
    {
        if ($this->isRefreshing) {
            return;  // Detener si ya está en proceso de refresco
        }

        $this->isRefreshing = true;

        // Tu lógica de refresco aquí

        $this->isRefreshing = false;  // Marcar como finalizado
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id')
             ->setTableAttributes([
                 'class' => 'table-auto table-bordered table-striped',
             ])
             ->setTheadAttributes([
                 'class' => 'thead-dark'  // Aquí añadimos la clase para el estilo de encabezado oscuro
             ])
             ->setDefaultSort('id', 'asc')
             ->setSortingPillsStatus(false)
             ->setPerPageAccepted([10, 25, 50, 100])
             ->setPerPage(10)
             ->setLayout('layouts.app')
             ->setBulkActionsEnabled()
             ->setHideBulkActionsWhenEmptyEnabled();
    }

    // Método para manejar el clic en una fila
    public function getTableRowUrl($row): ?string
    {
        return '#';  // No redirige a ninguna URL
    }

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
        $this->dispatch('openVentaModal', id: $id)->to('venta-component');
    }

    public function viewShowModal($id): void
    {
        $this->dispatch('openShowVentaModal', id: $id)->to('venta-component');
    }

    public function deleteVentaTable($id): void
    {
        Log::info("ID de la deleteVentaTable, venta enviado: " . $id);
        $this->dispatch('borrarRegistro', $id)->to('venta-component');
        Log::info("deleteVentaTable enviado a venta-component " . $id);
    }

    // Definir las columnas de la tabla
    public function columns(): array
    {
        return [
            Column::make("id", "id")->hideIf(true), // quiero ocultar esa columna pero enviar el dato
            Column::make("Folio", "folio")->searchable()->sortable(),
            Column::make("Costo", "cost")->searchable()->sortable(),
            Column::make("Usuario", "user.name")->searchable()->sortable(),
            Column::make("Origen", "origin_id")->searchable()->sortable(),
            Column::make("Estado", "state_id")->searchable()->sortable(),
            Column::make("Metodo de pago", "method_id")->sortable(),
            Column::make("Fecha", "date")->searchable()->sortable(),

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
                        'class' => 'btn btn-success w-8 h-8 flex items-center justify-center rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75',
                        'wire:click.prevent' => 'viewShowModal(' . $row->id . ')',
                    ])
                    ->html(),

                    LinkColumn::make('Delete')
                    ->title(fn($row) => '<i class="fas fa-trash"></i>')
                    ->location(fn($row) => '#')
                    ->attributes(fn($row) => [
                        'class' => 'btn btn-danger w-8 h-8 flex items-center justify-center rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75',
                        'wire:click.prevent' => 'deleteVentaTable(' . $row->id . ')',
                    ])
                    ->html(),
                          // ✅ Botón PDF
        LinkColumn::make('PDF')
        ->title(fn($row) => '<i class="fas fa-file-pdf"></i>')
        ->location(fn($row) => route('ventas.pdf', $row->id))
        ->attributes(fn($row) => [
            'class' => 'btn btn-secondary w-8 h-8 flex items-center justify-center rounded-md hover:bg-gray-700',
            'target' => '_blank', // abre en nueva pestaña
        ])
        ->html(),
                ]),
        ];
    }
}
