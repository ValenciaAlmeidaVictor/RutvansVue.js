<?php

namespace App\Http\Controllers;

use App\Exports\LocalidadesExport;
use Illuminate\Http\Request;
use App\Models\Localidad;
use Maatwebsite\Excel\Facades\Excel;

class EXCELController extends Controller
{
    public function expLocalidades(Request $request)
    {
        $query = Localidad::query();

        // Filtro por búsqueda
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('locality', 'like', '%' . $request->search . '%')
                    ->orWhere('street', 'like', '%' . $request->search . '%');
            });
        }

        // Filtro por una fecha específica
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '=', $request->start_date);
        }

        // Exportar a Excel
        return Excel::download(new LocalidadesExport($query), 'localidades.xlsx');
    }
}
