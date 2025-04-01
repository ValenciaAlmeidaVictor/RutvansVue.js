<?php

namespace App\Http\Controllers;

use App\Models\Localidad; // Modelo que representa las localidades
use Illuminate\Http\Request; // Clase para manejar solicitudes HTTP
use Barryvdh\DomPDF\Facade\Pdf; // Facade para generar PDFs con DomPDF

class PDFController extends Controller
{
    // Función para exportar localidades a PDF con soporte para filtros
    public function expLocalidades(Request $request)
    {
        $query = Localidad::query(); // Crea una consulta base para el modelo Localidad

        // Filtro por búsqueda
        // Se busca en las columnas 'locality' y 'street' con base en el término proporcionado
        $filtroBuscado = $request->search ?? 'Ninguno'; // Si no se proporciona, se asigna 'Ninguno'
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('locality', 'like', '%' . $request->search . '%') // Filtra por localidad
                    ->orWhere('street', 'like', '%' . $request->search . '%'); // O filtra por calle
            });
        }

        // Filtro por una fecha específica
        // Se filtran los registros según la fecha en 'created_at'
        $fechaConsultada = $request->start_date ?? 'No especificada'; // Si no se proporciona fecha, se asigna 'No especificada'
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '=', $request->start_date); // Filtra por fecha exacta
        }

        // Total de datos (sin filtros) y datos mostrados (después de aplicar filtros)
        $totalDatos = Localidad::count(); // Cuenta todos los registros en la tabla Localidad
        $localidades = $query->get(); // Obtiene los datos filtrados
        $datosMostrados = $localidades->count(); // Cuenta los registros filtrados

        // Generar el PDF
        // Carga una vista Blade con los datos filtrados y detalles adicionales
        $pdf = Pdf::loadView('exports.localidades.localidades_pdf', compact(
            'localidades',      // Datos de las localidades
            'fechaConsultada',  // Fecha seleccionada en el filtro
            'filtroBuscado',    // Texto buscado en el filtro
            'totalDatos',       // Total de registros sin filtrar
            'datosMostrados'    // Total de registros mostrados después de filtrar
        ));

        // Descarga el PDF generado
        return $pdf->download('localidades.pdf');
    }
}
