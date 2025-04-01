<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Horario;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Carbon\Carbon;

class HorariosTable extends DataTableComponent
{
    protected $model = Horario::class;

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

    public function viewModal($horarioId): void
    {
        $this->dispatch('openHorarioModal', horarioId: $horarioId)->to('horario-component');
    }

    public function viewShowModal($horarioId): void
    {
        $this->dispatch('openShowHorarioModal', horarioId: $horarioId)->to('horario-component');
    }

    public function deleteHorarioTable($horarioId): void
    {
        $this->dispatch('borrarRegistro', horarioId: $horarioId)->to('horario-component');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")->hideIf(true), 
    
            Column::make("Hora de Salida", "departure_time")
                ->searchable()
                ->sortable()
                ->format(fn ($value) => Carbon::parse($value)->format('h:i A')),
    
            Column::make("Hora de Llegada", "arrival_time")
                ->searchable()
                ->sortable()
                ->format(fn ($value) => Carbon::parse($value)->format('h:i A')),
    
            Column::make("Día", "day")
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
                            'class' => 'btn btn-success w-8 h-8 flex items-center justify-center rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'viewShowModal(' . $row->id . ')', 
                        ])
                        ->html(), 
    
                    LinkColumn::make('Eliminar')
                        ->title(fn($row) => '<i class="fas fa-trash"></i>')
                        ->location(fn($row) => '#')
                        ->attributes(fn($row) => [
                            'class' => 'btn btn-danger w-8 h-8 flex items-center justify-center rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75',
                            'wire:click.prevent' => 'deleteHorarioTable(' . $row->id . ')', 
                        ])
                        ->html(), 
                ])
        ];
    }    
}
