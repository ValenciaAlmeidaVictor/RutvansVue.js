<?php

namespace App\Http\Controllers;

use App\Exports\LocalidadesExport;
use Maatwebsite\Excel\Facades\Excel;

class EXCELController extends Controller
{
    // Función para exportar las localidades a Excel
    public function localidades()
    {
        // Descarga el archivo Excel basado en la clase de exportación
        return Excel::download(new LocalidadesExport, 'localidades.xlsx');
    }

    // Puedes agregar más funciones para otras tablas aquí
}
