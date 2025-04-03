<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidades;
use App\Models\Schedule;
use App\Models\HorarioUnidad;
use App\Models\Drivers;

class UnitScheduleController extends Controller
{
    public $UnidadHorarios, $id_Units, $id_Schedules, $id_Driver, $status, $day , $data;

    public function index()
    {
        // Obtén las unidades, horarios y conductores desde la base de datos
        $units = Unidades::all();
        $schedules = Schedule::all();
        $drivers = Drivers::all();
        
        return view('dashboard', compact('units', 'schedules', 'drivers'));
    }

    //trae los datos de las tablas relacionadas con FK
    public function getUnitSchedules(Request $request)
    {
        return response()->json([
            'units' => Unidades::all(),
            'schedules' => Schedule::all(),
            'driver' => Drivers::all()
        ]);
    }

    //crear un evento en el calendario y guardarlo en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'id_Units' => 'required|exists:units,id',
            'id_Schedules' => 'required|exists:schedules,id',
            'id_Driver' => 'required|exists:driver,id',
            'status' => 'required|in:activo,inactivo',
            'day' => 'required|date'
        ]);

        HorarioUnidad::create([
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status,
            'day' => $request->day,
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Registro guardado correctamente'
        ]);
    }

    //Funcion para editar un evento en el calendario
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_Units' => 'required|exists:units,id',
            'id_Schedules' => 'required|exists:schedules,id',
            'id_Driver' => 'required|exists:driver,id',
            'status' => 'required|in:activo,inactivo',
            'day' => 'required|date'
        ]);

        $schedule = HorarioUnidad::findOrFail($id);
        $schedule->update([
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status,
            'day' => $request->day,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registro actualizado correctamente'
        ]);
    }

    //Devolucion de los datos para imprimirlos en el calendario
    public function getEvents()
    {
        $schedules = HorarioUnidad::with(['unit:id,plate', 'schedule:id,departure_time', 'driver:id,name'])->get();

        $events = $schedules->map(function ($schedule) {
            return [
                'title' => "Unidad: {$schedule->unit->plate}, 
                            Horario: {$schedule->schedule->departure_time}, 
                            Conductor: {$schedule->driver->name}",
                'start' => "{$schedule->day} {$schedule->schedule->departure_time}",
                'allDay' => true,
                'color' => $schedule->status === 'activo' ? 'green' : 'red' // Color según estado selcionado
            ];
        });

        return response()->json($events);
    }



    //apartir de aqui son funciones de la API para visualizar en el Frondend
    public function inicio()
    {
        $UnidadHorarios = HorarioUnidad::all();
        return response()->json($UnidadHorarios, 200);
    }
    public function buscar($campo, $valor = null)
    {
        // Validar que el campo sea uno de los existentes
        $campos_validos = ['id_Units', 'id_Schedules', 'id_Driver', 'status', 'day'];
        
        if (!in_array($campo, $campos_validos)) {
            return response()->json(['error' => 'Campo inválido'], 400); // Respuesta en caso de campo inválido
        }

        // Realizar la búsqueda según el campo
        $UnidadHorarios = HorarioUnidad::where($campo, 'like', "%$valor%")->get();

        // Devolver los resultados en formato JSON
        return response()->json($UnidadHorarios, 200);
    }

    public function agregar( Request $request){

        $UnidadHorarios = HorarioUnidad::create([
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status,
            'day' => $request->day,
        ]);

        $data =[
            'id_Units' => $UnidadHorarios,
            'id_Schedules' => $UnidadHorarios,
            'id_Driver' => $UnidadHorarios,
            'status' => $UnidadHorarios,
            'day' => $UnidadHorarios,
        ];
         return response()->json($data,200);
    }

    public function insertar(Request $request)
    {
        $request->validate([
            'id_Units' => 'required|exists:units,id',
            'id_Schedules' => 'required|exists:schedules,id',
            'id_Driver' => 'required|exists:driver,id',
            'status' => 'required|in:activo,inactivo',
            'day' => 'required|date'
            ]);

        
        $UnidadHorarios = HorarioUnidad::create([
            'id_Units' => $request->id_Units,
            'id_Schedules' => $request->id_Schedules,
            'id_Driver' => $request->id_Driver,
            'status' => $request->status,
            'day' => $request->day,
        ]);

        $data = [
            'id_Units' => $UnidadHorarios->id_Units,
            'id_Schedules' => $UnidadHorarios->id_Schedules,
            'id_Driver' => $UnidadHorarios->id_Driver,
            'status' => $UnidadHorarios->status,
            'day' => $UnidadHorarios->day,
            'status' => 200
        ];

        return response()->json($data, 200);
    }
    //Fin Funciones Apis

}
