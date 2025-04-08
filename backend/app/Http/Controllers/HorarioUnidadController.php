<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HorarioUnidad;
use App\Models\Unidades;
use App\Models\Schedule;
use App\Models\Drivers;

class HorarioUnidadController extends Controller
{
    public function index()
    {
        $horarios = HorarioUnidad::with(['unit', 'schedule', 'driver'])->get();

        $events = $horarios->map(function ($horario) {
            return [
                'id' => $horario->id,
                'title' => "{$horario->unit->plate} - {$horario->driver->name}",
                'start' => $horario->day, 
                'backgroundColor' => $horario->status === 'Activo' ? 'green' : 'red',
                'borderColor' => 'black',
                'extendedProps' => [
                    'driver' => $horario->driver->name,
                    'unit' => $horario->unit->plate,
                    'schedule' => $horario->schedule->departure_time,
                    'status' => $horario->status
                ]
            ];
        });
    
        return response()->json($events);
    }


    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|date',
            'id_Units' => 'required|integer',
            'id_Schedules' => 'required|integer',
            'id_Driver' => 'required|integer',
            'status' => 'required|in:Activo,inActivo'
        ]);

        $horario = HorarioUnidad::create([
            'day' => $request->day,
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status
        ]);

        return response()->json($horario);
    }

    public function getSelectors()
    {
        $units = Unidades::select('id', 'plate')->get();
        $schedules = Schedule::select('id', 'departure_time')->get();
        $drivers = Drivers::select('id', 'name')->get();

        return response()->json([
            'units' => $units,
            'schedules' => $schedules,
            'drivers' => $drivers,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'day' => 'required|date',
            'id_Units' => 'required|integer',
            'id_Schedules' => 'required|integer',
            'id_Driver' => 'required|integer',
            'status' => 'required|in:Activo,inActivo'
        ]);

        $horario = HorarioUnidad::find($id);
        if (!$horario) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $horario->update([
            'day' => $request->day,
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status
        ]);

        return response()->json(['message' => 'Registro actualizado correctamente']);
    }

    public function destroy($id)
    {
        $horario = HorarioUnidad::find($id);

        if (!$horario) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $horario->delete(); // Elimina el registro de la base de datos

        return response()->json(['message' => 'Registro eliminado correctamente']);
    }

    //Funciones para la API
    public function getFilteredEvents(Request $request)
    {
        $query = HorarioUnidad::with(['unit', 'schedule', 'driver']);

        if ($request->has('day')) {
            $query->where('day', $request->day);
        }

        if ($request->has('unit_id')) {
            $query->where('id_Units', $request->unit_id);
        }

        if ($request->has('driver_id')) {
            $query->where('id_Driver', $request->driver_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $horarios = $query->get();
        $events = $horarios->map(function ($horario) {
            return [
                'id' => $horario->id,
                'title' => "{$horario->unit->plate} - {$horario->driver->name}",
                'day' => $horario->day,
                'status' => $horario->status,
                'unit' => $horario->unit->plate,
                'driver' => $horario->driver->name,
                'schedule' => $horario->schedule->departure_time,
            ];
        });

        return response()->json($events);
    }

    public function getHorariosByStatus($status)
    {
        $horarios = HorarioUnidad::with(['unit', 'schedule', 'driver'])
                    ->where('status', $status) // Filtrar por el estado
                    ->get();

        
        $events = $horarios->map(function ($horario) {
            return [
                'id' => $horario->id,
                'title' => "{$horario->unit->plate} - {$horario->driver->name}",
                'day' => $horario->day,
                'status' => $horario->status,
                'unit' => $horario->unit->plate,
                'driver' => $horario->driver->name,
                'schedule' => $horario->schedule->departure_time,
            ];
        });

        return response()->json($events);
    }

}
