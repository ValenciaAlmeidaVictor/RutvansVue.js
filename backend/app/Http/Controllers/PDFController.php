<?php

namespace App\Http\Controllers;

use App\Models\Localidad;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    // Función para exportar localidades a PDF con soporte para filtros
    public function expLocalidades(Request $request)
    {
        $query = Localidad::query();

        // Filtro por búsqueda
        $filtroBuscado = $request->search ?? 'Ninguno';
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('locality', 'like', '%' . $request->search . '%')
                    ->orWhere('street', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por una fecha específica
        $fechaConsultada = $request->start_date ?? 'No especificada';
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '=', $request->start_date);
        }

        $totalDatos = Localidad::count();
        $localidades = $query->get();
        $datosMostrados = $localidades->count();

        // Generar el PDF
        $pdf = Pdf::loadView('exports.localidades.localidades_pdf', compact(
            'localidades',
            'fechaConsultada',
            'filtroBuscado',
            'totalDatos',
            'datosMostrados'
        ));

        return $pdf->download('localidades.pdf');
    }
}
