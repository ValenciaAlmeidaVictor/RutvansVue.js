<?php

namespace App\Exports;

use App\Models\Localidad;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LocalidadesExport implements FromView, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function view(): View
    {
        return view('exports.localidades.localidades_excel', [
            'localidades' => $this->query->get()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Encabezado
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'FF6600']],
                'alignment' => ['horizontal' => 'center'],
            ],

            // Bordes y alternancia de colores
            'A2:F1000' => [
                'borders' => ['outline' => ['borderStyle' => 'thin', 'color' => ['rgb' => '000000']]],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'F2F2F2']],
            ],
        ];
    }
}
