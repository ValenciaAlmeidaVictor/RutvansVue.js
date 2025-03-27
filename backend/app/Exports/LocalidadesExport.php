<?php

namespace App\Exports;

use App\Models\Localidad;
use Maatwebsite\Excel\Concerns\FromCollection;

class LocalidadesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Localidad::all();
    }
}
